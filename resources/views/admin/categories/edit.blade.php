@extends('layouts.admin')
@section('title', @ucfirst(__('app.editCat')))
@section('css-file')
<link rel="stylesheet" href="{{ asset('/css/leaflet.awesome-markers.min.css') }}" />
@endsection
@section('css-style')
<style>
.awesome-marker-choice {
  position:relative !important;
}
</style>
@endsection

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 h2 mb-3">
        <i class="fas fa-folder-open" aria-hidden="true"></i> @ucfirst(__('app.editCat'))
    </h1>
</div>
@if ($errors->any())
<div class="row d-flex justify-content-center">
    <div class="col-6 mx-3 alert alert-danger">
        <ol>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
</div>
@endif
<div class="row d-flex justify-content-center">
    <div class="col-6">
        <form action="{{ route('category.update') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="user_uuid" value="{{ $currentUser->uuid }}" />
            <input type="hidden" name="cat_uuid" value="{{ $category->uuid }}" />
            <div class="">
                <p class="text-justify">
                    @ucfirst(__('app.updCatInstruction'))
                </p>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="input-category"><i class="fas fa-folder-open" aria-hidden="true"></i></span>
                </div>
                <input type="text" name="name" class="form-control border-secondary" placeholder="@ucfirst(__('app.formCategory'))" value="{{ $category->name }}" aria-label="@ucfirst(__('app.category'))" aria-describedby="input-category"@empty($category->user_uuid) {{ 'readonly' }} @endempty />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="input-icon"><i class="fas fa-image" aria-hidden="true"></i></span>
                </div>
                <input type="text" name="icon" class="form-control border-secondary" placeholder="@ucfirst(__('app.formIcon'))" value="{{ $category->icon }}" aria-label="@ucfirst(__('app.formIcon'))" aria-describedby="input-icon"@empty($category->user_uuid) {{ 'readonly' }} @endempty />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="input-color"><i class="fas fa-palette" aria-hidden="true"></i></span>
                </div>
                <input type="text" id="color" name="color" class="form-control border-secondary" autocomplete="off" placeholder="@ucfirst(__('app.formColor'))" value="{{ $category->color }}" aria-label="@ucfirst(__('app.formColor'))" aria-describedby="input-color" />
                <div class="row mt-3 table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td id="aml" data-color="lightred">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-lightred">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="red">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-red">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="darkred">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-darkred">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="lightgreen">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-lightgreen">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="green">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-green">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="darkgreen">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-darkgreen">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="lightblue">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-lightblue">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="blue">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-blue">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="darkblue">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-darkblue">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td id="aml" data-color="cadetblue">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-cadetblue">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="purple">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-purple">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="darkpurple">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-darkpurple">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="pink">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-pink">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="orange">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-orange">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="beige">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-beige">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="white">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-white">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="gray">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-gray">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                            <td id="aml" data-color="black">
                                <span class="awesome-marker awesome-marker-choice awesome-marker-icon-black">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="input-description"><i class="fas fa-comment-alt" aria-hidden="true"></i></span>
                </div>
                <textarea id="descForm" name="description" class="form-control border-secondary" placeholder="@ucfirst(__('app.formDescription'))" rows="5" aria-label="@ucfirst(__('app.formDescription'))" aria-describedby="input-description"@empty($category->user_uuid) {{ 'readonly' }} @endempty />{{ $category->description }}</textarea>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save" aria-hidden="true"></i> @ucfirst(__('app.save'))</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$("td#aml").click(function( index ) {
    var choix = $(this).data('color');
    $("#color").val(choix);
});
</script>
@endsection