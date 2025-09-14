<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function index(Request $request): JsonResponse
  {

    $search = self::format($request->input('term', ''));
    $res = Category::when(
      $search,
      fn($query) =>
      $query->where('name', 'like', "%{$search}%")
    )->select('id', 'name')
      ->orderBy('name')
      ->paginate(10)
      ->toArray();

    return response()->json([
      'results' => array_map(fn($r) => [
        'id' => $r['id'],
        'text' => $r['name'],
      ], $res['data']),
      'pagination' => ['more' => $res['current_page'] < $res['last_page']],
    ]);
  }

  public static function format($frase)
  {
    $palavras = explode(" ", $frase);
    $pesquisa = '';
    $palavrasIgnorar = ['de'];

    foreach ($palavras as $palavra) {
      if (!in_array($palavra, $palavrasIgnorar))
        $pesquisa = $pesquisa . '%' . $palavra;
    }

    return $pesquisa;
  }

}
