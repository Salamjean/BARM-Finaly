<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    /**
     * Télécharge un document de manière sécurisée en PDF.
     * Si le fichier physique existe, il est servi directement en téléchargement PDF.
     * S'il n'existe pas localement, un PDF officiel BARM est généré à la volée.
     */
    public function download(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string',
            'name' => 'nullable|string|max:255',
            'user' => 'nullable|string|max:255',
            'matricule' => 'nullable|string|max:255',
        ]);

        $rawPath = $validated['path'];
        $name = $validated['name'] ?? 'Document';
        $userName = $validated['user'] ?? null;
        $matricule = $validated['matricule'] ?? null;

        if (empty($rawPath)) {
            return back()->with('error', 'Aucun document spécifié.');
        }

        // Nettoyer le chemin contre les traversées de répertoire
        $cleanedPath = ltrim(str_replace(['../', '..\\', './', '.\\'], '', $rawPath), '/\\');

        // Emplacements potentiels du fichier
        $possiblePaths = [
            public_path($cleanedPath),
            base_path($cleanedPath),
            public_path('public/' . $cleanedPath),
            storage_path('app/public/' . $cleanedPath),
            public_path('data/docs/' . basename($cleanedPath)),
            public_path('data/' . $cleanedPath),
        ];

        $foundFilePath = null;
        foreach ($possiblePaths as $testPath) {
            if (File::exists($testPath) && is_file($testPath)) {
                $foundFilePath = $testPath;
                break;
            }
        }

        // Déterminer un nom de fichier propre pour le téléchargement
        $slugName = Str::slug($name, '_');
        $baseName = basename($cleanedPath);
        $cleanFileName = $slugName ? ($slugName . '.pdf') : ($baseName ?: 'document.pdf');
        if (!Str::endsWith(strtolower($cleanFileName), '.pdf')) {
            $cleanFileName .= '.pdf';
        }

        // 1. Si le fichier physique existe sur le disque
        if ($foundFilePath) {
            $extension = strtolower(pathinfo($foundFilePath, PATHINFO_EXTENSION));

            // Si c'est un PDF, le servir en téléchargement direct avec les en-têtes adéquats
            if ($extension === 'pdf') {
                return response()->download($foundFilePath, $cleanFileName, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $cleanFileName . '"',
                    'Cache-Control' => 'no-cache, private'
                ]);
            }

            // Si c'est une image (jpg, jpeg, png), on la convertit ou la sert proprement
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                $imgName = $slugName ? ($slugName . '.' . $extension) : $baseName;
                return response()->download($foundFilePath, $imgName, [
                    'Content-Type' => File::mimeType($foundFilePath),
                    'Content-Disposition' => 'attachment; filename="' . $imgName . '"',
                ]);
            }

            return response()->download($foundFilePath, $cleanFileName);
        }

        // 2. Si le fichier physique est introuvable sur le disque (base de test / fichier archivé)
        // On génère dynamiquement un vrai document PDF officiel du BARM pour éviter tout "fichier Google" (HTML 404)
        $pdf = Pdf::loadView('pdf.document_placeholder', [
            'name' => $name,
            'path' => $cleanedPath,
            'userName' => $userName,
            'matricule' => $matricule,
            'date' => now()->format('d/m/Y à H:i'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download($cleanFileName);
    }
}
