@extends('layouts.app')
@section('content')
    <div class="container pt-4">
        @if ($step !== 'import_data')
            <h2>Charger la liste des retraité</h2>
            <form action="{{ route('excel.import.adherent_list') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input class="form-control" accept=".xlsx, .xls" type="file" name="file" required>
                </div>
                <button type="submit" class="btn btn-primary">Importer</button>
            </form>
        @else
        <form action="{{ route('excel.import.adherent_list') }}" method="post">
                @csrf
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Validé</button>
            </div>
            <table class="dt-responsive table table-striped" id="datatable--barm">
                <thead>
                    <tr>
                        <th>ANNEE</th>
                        <th>GRADE</th>
                        <th>MECANO</th>
                        <th>MATRICULE</th>
                        <th>NOM</th>
                        <th>PRENOMS</th>
                        <th>DATE DE NAISSANCE</th>
                        <th>GENRE</th>
                        <th>UNITE</th>
                        <th>ARMEE</th>
                        <th>DATE DE RETRAITE</th>
                        <th>TYPE DE RETRAIRE</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $retireds_data = [];
                        $increment = 0;
                    @endphp
                    @foreach ($retireds_list as $key => $retireds)
                        {{-- <tr>
                            <th colspan="11">Feuille {{ $key + 1 }}</th>
                        </tr> --}}
                        @foreach ($retireds as $keyy => $retired)
                            @if ($keyy != 0)
                                <tr>
                                    @foreach ($retired as $keyyy => $element)
                                        @php
                                            $retireds_data[$increment][$keyyy] = $element ?? null;
                                            $type = 0;
                                            if (in_array($keyyy, [6, 10])) {
                                                $type = 1;
                                            }
                                        @endphp
                                        <td>{{ $type == 0 ? $element : dateFr($element) }}</td>
                                    @endforeach
                                </tr>
                                @php
                                    $increment++;
                                @endphp
                            @endif
                        @endforeach
                    @endforeach

                </tbody>
            </table>
            <input type="hidden" name="step" value="import_upload" />
             <input type="hidden" name="retireds" value="{{ json_encode($retireds_data) }}" />
        </form>
        @endif
    </div>
@endsection
