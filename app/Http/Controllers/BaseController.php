<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
class BaseController extends Controller
{
    //
    use Helpers;
    protected $authenticationToken;
    public function __construct ()
    {
        $this->authenticationToken = "awm-MGcoaPlr_tCzAPmfSTc294X0JBgsZ8YOw86Rv1YMeGbY8ZVOIP9_3jk-0lICnl1yf_G1EfW1WxZSpkfX5KnmajFCbjyQ_irZz1ke-q_ey9AO_m2qX-1wZp25zQk45fvO1WaNkHCU1i5ni8q9zaYNF0JGmK9TmB6q931JXsz0SszTjJ1Ey0iOvohXu_Rs1uMk5ieaKPy9ZkXq_eJODg";
    }
}
