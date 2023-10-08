<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Upload CSV File in Laravel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container my-lg-5 my-3">
        <div class="row justify-content-center">

            <h3 class="text-center">Upload CSV File in Laravel</h3>

            <form class="col-lg-8 col-md-10 col-12 my-5" 
                method="post" 
                action="{{ route('log_import.store') }}" 
                enctype="multipart/form-data">
                @csrf

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12">
                        <input class="form-control form-control-lg @error('file_path') is-invalid @enderror" 
                            id="file_path" 
                            name="file_path" 
                            type="file">
                        @error('file_path')
                        <div id="validation_file_path_feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        @if (session()->has('success_msg'))
                        <x-alert 
                            type="success" 
                            message="{{ session('success_msg') }}" 
                            close="true" 
                            class="alert-dismissible fade show mt-3 mb-0" />
                        @endif

                        @if (session()->has('error_msg'))
                        <x-alert 
                            type="danger" 
                            message="{{ session('error_msg') }}" 
                            close="true" 
                            class="alert-dismissible fade show mt-3 mb-0" />
                        @endif
                    </div>
                    <div class="col-lg-3 col-6">
                        <button class="btn btn-lg btn-success mt-lg-0 mt-3 text-nowrap">Upload File</button>
                    </div>
                </div>
            </form>

            <div class="col-lg-12 col-12 table-responsive">
                <x-table class="table-bordered log-imports">
                    <x-slot name="thead">
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th scope="col">Time</th>
                            <th scope="col">File Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Completion</th>
                        </tr>
                    </x-slot>

                    <tr>
                        <td colspan="5" class="text-center">Loading...</td>
                    </tr>
                </x-table>

                <div class="mt-3">
                    <strong>Download example files:</strong>
                    <ul>
                        <li><a href="{{ asset('docs/yoprint_test_import.csv') }}" target="_blank" class="text-dark">yoprint_test_import.csv</a></li>
                        <li><a href="{{ asset('docs/yoprint_test_updated.csv') }}" target="_blank" class="text-dark">yoprint_test_updated.csv</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
