<?php

namespace App\Presenters;

use App\Transformers\CreativeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CreativePresenter.
 *
 * @package namespace App\Presenters;
 */
class CreativePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CreativeTransformer();
    }
}
