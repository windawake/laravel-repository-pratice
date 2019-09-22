<?php

namespace App\Presenters;

use App\Transformers\AdminTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AdminPresenter.
 *
 * @package namespace App\Presenters;
 */
class AdminPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AdminTransformer();
    }
}
