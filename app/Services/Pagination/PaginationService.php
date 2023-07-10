<?php

namespace App\Services\Pagination;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PaginationService
{
    public function __construct(protected array $config)
    {
    }

    protected function paginate($results, string $query, string $mediaType)
    {
        $links = [];

        $links['0']['active'] = false;
        $links['0']['label'] = '&laquo; Précédent';
        $links['0']['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $results['page'] - 1;
        if($results['page'] - 1 === 0) {
            $links['0']['url'] = null;
        }
        if ($results['total_pages'] > 20) {
            for ($i = 1; $i <= 3; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }

            $links['4']['active'] = false;
            $links['4']['label'] = '...';
            $links['4']['url'] = null;

            if ($results['page'] != 1) {
                for ($i = $results['page'] - 1 ; $i <= $results['page'] + 1; $i++) {
                    if($i === $results['page']) {
                        $links[$i]['active'] = true;
                    } else {
                        $links[$i]['active'] = false;
                    }
                    $links[$i]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $i;
                    if ($results['page'] - 1) {
                    }
                    $links[$i]['label'] = $i;
                }
            }

            if ($results['page'] >= 3 && $results['page'] < $results['total_pages'] - 4) {
                $links[$results['total_pages'] - 3]['active'] = false;
                $links[$results['total_pages'] - 3]['label'] = '...';
                $links[$results['total_pages'] - 3]['url'] = null;
            }

            for ($i = $results['total_pages'] - 2 ; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }

        } else {
            for ($i = 1; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }
        }
        $links[$results['total_pages'] + 1]['active'] = false;
        $links[$results['total_pages'] + 1]['label'] = 'Suivant &raquo;';
        $links[$results['total_pages'] + 1]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $results['page'] + 1;
        if($results['page'] + 1 > $results['total_pages']) {
            $links[$results['total_pages'] + 1]['url'] = null;
        }

    }
}
