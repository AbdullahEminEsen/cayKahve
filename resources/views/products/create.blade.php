@extends('layouts.app')

@section('content')
    <style>
        input[type=file] {
            width: 350px;
            max-width: 100%;
            color: #444;
            padding: 5px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #555;
        }
        input[type=file]::file-selector-button {
            margin-right: 20px;
            border: none;
            background: #084cdf;
            padding: 10px 20px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }

        input[type=file]::file-selector-button:hover {
            background: #0d45a5;
        }
        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }
        .drop-container.drag-active {
            background: #eee;
            border-color: #111;
        }

        .drop-container.drag-active .drop-title {
            color: #222;
        }
    </style>
    <div class="container mt-2">
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section >
                <div class="container py-5 ">
                    <div class="row d-flex justify-content-center align-items-center ">
                        <span class="mt-2 bg-danger text-center w-75 mx-auto rounded mb-3">
                        @foreach($errors->all() as $error)
                                <div>
                           {!! $error !!}
                            </div>
                            @endforeach
                             </span>
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card" style="border-radius: 1rem;">
                                <a href="{{ route('products.index') }}" class="btn btn-sm px-4 mx-lg-2 mt-2 w-25">Geri Dön</a>
                                <div class="card-body p-5 text-center">

                                    <div class="mb-md-5 mt-md-4">

                                        <h2 class="fw-bold mb-2 text-uppercase">Ürün Ekleme</h2>
                                        <p class=" mb-5">Lütfen Ürün bilgilerini giriniz.</p>

                                        <div class="form-outline mb-4">
                                            <input type="text" id="name" name="name" class="border border-gray text-center rounded-pill form-control form-control-lg" />
                                            <label class="form-label" for="typeEmailX">Ürün Adı</label>
                                        </div>

                                        <label for="images" class="drop-container" id="dropcontainer">
                                            <span class="drop-title">Drop files here</span>
                                            or
                                            <input type="file" id="images" name="image" accept="image/*" required>
                                        </label>

                                        <button class="btn btn-outline-dark btn-lg px-5 mt-5" type="submit" id="kt_sign_in_submit">Ürün Ekle</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
    <script>
        const dropContainer = document.getElementById("dropcontainer")
        const fileInput = document.getElementById("images")

        dropContainer.addEventListener("dragover", (e) => {
            // prevent default to allow drop
            e.preventDefault()
        }, false)

        dropContainer.addEventListener("dragenter", () => {
            dropContainer.classList.add("drag-active")
        })

        dropContainer.addEventListener("dragleave", () => {
            dropContainer.classList.remove("drag-active")
        })

        dropContainer.addEventListener("drop", (e) => {
            e.preventDefault()
            dropContainer.classList.remove("drag-active")
            fileInput.files = e.dataTransfer.files
        })
    </script>
@endsection
