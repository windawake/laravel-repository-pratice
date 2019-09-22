<?php

namespace App\Presenters;

use App\Transformers\OfferTransformer;
use App\Transformers\OrderTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 *
 * @package namespace App\Presenters;
 */
class OrderPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrderTransformer();
    }
}
