<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ScrapingController extends Controller
{
    public function scrape()
    {
        $url = 'https://lista.mercadolivre.com.br/veiculos/carros-caminhonetes/honda/civic/';
        $client = new Client();

        Log::info('Iniciando processo de scraping', [
            'url' => $url,
            'timestamp' => now()
        ]);

        try {
            // Fazendo a requisição para obter o HTML da página
            $response = $client->get($url, [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
                ]
            ]);
            $html = $response->getBody()->getContents();

            Log::info('Requisição realizada com sucesso', [
                'response_length' => strlen($html)
            ]);

            // Inicializa o Crawler com o HTML obtido
            $crawler = new Crawler($html);

            $productCount = 0;
            $failedProducts = 0;

            // Iterando pelos produtos encontrados na página
            $crawler->filter('.andes-card.poly-card')->each(function (Crawler $node) use (&$productCount, &$failedProducts) {
                try {
                    // Obtendo a URL da imagem
                    $imageUrl = $node->filter('.poly-card__portada img')->attr('data-src')
                        ?? $node->filter('.poly-card__portada img')->attr('src');

                    // Obtendo o título do produto
                    $title = $node->filter('.poly-component__title')->text();

                    // Obtendo o preço
                    $priceText = $node->filter('.andes-money-amount__fraction')->text();
                    $price = floatval(str_replace('.', '', $priceText));

                    // Salvando no banco
                    Product::create([
                        'name' => $title,
                        'price' => $price,
                        'image_url' => $imageUrl,
                    ]);

                    $productCount++;
                } catch (\Exception $e) {
                    $failedProducts++;
                    Log::warning('Falha ao processar produto', [
                        'error' => $e->getMessage(),
                        'title' => $title ?? 'Título não capturado'
                    ]);
                }
            });

            Log::info('Processo de scraping concluído', [
                'total_products' => $productCount,
                'failed_products' => $failedProducts
            ]);

            return response()->json([
                'message' => 'Produtos extraídos e salvos com sucesso!',
                'total_products' => $productCount,
                'failed_products' => $failedProducts
            ]);
        } catch (\Exception $e) {
            Log::error('Erro crítico no processo de scraping', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Erro ao acessar a página: ' . $e->getMessage()], 500);
        }
    }

    public function deleteAllProducts()
    {
        try {
            $totalProducts = Product::count();
            Product::truncate();

            Log::info('Produtos excluídos com sucesso', [
                'total_products' => $totalProducts
            ]);

            return response()->json([
                'message' => 'Todos os produtos foram excluídos com sucesso!',
                'total_products' => $totalProducts
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir produtos', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Erro ao excluir os produtos: ' . $e->getMessage()], 500);
        }
    }
}
