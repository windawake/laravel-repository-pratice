<?php

namespace App\Presenters;

use App\Transformers\BillingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BillingPresenter.
 *
 * @package namespace App\Presenters;
 */
class BillingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BillingTransformer();
    }
}
