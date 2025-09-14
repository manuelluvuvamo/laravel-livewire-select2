<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
  public function index(Request $request): JsonResponse
  {

    $search = self::format($request->input('term', ''));
    $category_id = $request->input('category_id', null);

    $res = SubCategory::when(
      $search,
      fn($query) =>
      $query->where('name', 'like', "%{$search}%")
    )
      ->when(
        $category_id,
        fn($query) =>
        $query->where('category_id', $category_id)
      )
      ->select('id', 'name')
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
