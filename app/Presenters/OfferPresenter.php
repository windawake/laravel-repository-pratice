<?php

namespace App\Presenters;

use App\Transformers\BillingTransformer;
use App\Transformers\OfferTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 *
 * @package namespace App\Presenters;
 */
class OfferPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OfferTransformer();
    }
}
