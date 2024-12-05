<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Desafio Leadtax</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<body>
    <nav class="bg-gray-100 py-3">
        <div class="container mx-auto px-4">
            <div class="flex justify-center items-center">
                <div class="flex space-x-4">
                    <form id="scrapeForm" method="GET" class="flex items-center">
                        @csrf
                        <button type="button" id="scrapeBtn"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out mr-2">
                            Realizar Scraping
                        </button>
                    </form>
                    <form id="deleteForm" method="POST" class="flex items-center">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="deleteBtn"
                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out">
                            Apagar Todos os Itens
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="mt-5">
        @yield('content')
    </div>

    <script>
        $(document).ready(function() {
            $('#scrapeBtn').click(function() {
                // Loading
                $(this).prop('disabled', true).text('Carregando...');

                $.ajax({
                    url: "{{ route('products.scrape') }}",
                    method: 'GET',

                    success: function(data) {
                        alert('Scraping feito! Dados capturados.');

                        location.reload();
                    },

                    error: function(xhr) {
                        alert('Opa! Algo deu errado no scraping.');

                        console.error('Erro no scraping:', xhr.responseText);
                    },

                    complete: function() {
                        $('#scrapeBtn').prop('disabled', false).text('Realizar Scraping');
                    }
                });
            });

            $('#deleteBtn').click(function() {
                var confirmacao = confirm('Tem certeza que quer apagar TODOS os produtos?');

                if (confirmacao) {
                    $(this).prop('disabled', true).text('Apagando...');

                    $.ajax({
                        url: "{{ route('products.deleteAll') }}",
                        method: 'DELETE',

                        // Token de segurança do Laravel
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function(data) {
                            alert('Todos os produtos foram deletados.');

                            location.reload();
                        },

                        error: function(xhr) {
                            alert('Erro ao tentar deletar os produtos.');

                            console.error('Erro na deleção:', xhr.responseText);
                        },

                        complete: function() {
                            $('#deleteBtn').prop('disabled', false).text(
                                'Apagar Todos os Itens');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>
