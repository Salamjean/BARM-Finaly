@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        {{-- <div class="breadcrumb-title pe-3">Liste</div> --}}
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <h4 class="py-3 breadcrumb-wrapper mb-4">
                    <span class="text-muted fw-light">Archives/</span> Details archives
                </h4>
            </nav>
        </div>

        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('archive.liste') }}" type="button" class="btn btn-danger">Retour</a>
            </div>
        </div>
    </div>
    <style>
        .div-fixed-bottom {
    position: relative;
    bottom: 0;
    width: 100%; 
    background-color: #fff; 
    padding: 2px; 
    margin-top: 150px;
    }
    .checked {
  color: orange;
    }
    .whatsApp{
     color:green;
    }
    /* .heading{
        color:orange;
    } */
    .paragraphe{
        color:white;
    }
    </style>
    <div class="card bg-info">
        <div class="card-body">
         <div class="row d-flex align-items-center justify-content-center">
               <div class="col-xl-6 offset-xl-1 lg-mt-80 md-mt-80">
                   <div class="right-choose-content position-relative">
                       <img src="{{ asset('assets/images/'.$archive->image) }}"  alt="" class="img-fluid"
                       style="height: 500px; width: 500px;">                     <span style="background: rgba(210, 110, 5, 1) !important;"></span>
                        <span style="background: #FFFFFF !important;"></span>
                        <span style="background: rgba(1, 128, 78, 1) !important;"></span>
                    </div><br>
                    <a href="{{asset('assets/images/'.$archive->image)}}" class="btn btn-warning" download="{{ $archive->image }}">telecharger l'image</a>
                </div>
                <div class="col-xl-5 left-choose-content">
                    <div class="choose-us-heading">
                        <h2 class="text-justify mb-20 mt-20 heading" style="font-size: 38px;line-height: 48px;">
                         {{$archive->titre}}
                        </h2>
                          <p class="paragraphe">Titre du poste :{{$archive->description}}.</p>

                           <div class="row div-fixed-bottom">
                             <span class="col-6 mx"><b>Date de publication</b> :<br><span class="fa fa-star checked"></span>
                              {{ \Carbon\Carbon::parse($archive->date_publication)->format('d/m/Y') }}<span class="fa fa-star checked"></span></span><br>
                             <span class="col-6 "><b>Reseau Social </b>:<br></i>{{$archive->Dossier->nom}}
                             <span class="fa fa-star checked"></span>
                             <span class="fa fa-star checked"></span>
                             <span class="fa fa-star checked"></span>
                            </span>
                            </div>        
                   </div>
               </div>
           </div>
        </div>
    </div>
</div>
@endsection