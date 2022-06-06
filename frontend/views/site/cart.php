<?php 
use yii\helpers\Html;


use yii\widgets\ActiveForm;
use backend\models\ProductParams;
use backend\models\Product;
?>

<!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Cart</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active">Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Update</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $cost=0;
                                $discount=0;
                                $totaldiscount=0;
                                $shipping=0;
                                $totalcost=0;
                                foreach ($params as $param){
                                    $cost=$cost+$param['cost']*$param['count'];
                                    $discount=$discount+($param['cost']-($param['cost']*(100-$param['discount']))/100)*$param['count'];

                                    $totalcost=$cost-$discount+$shipping;



                                ?>
                                
                                <tr>
                                    <input type="hidden" name="basket_id" class="basket_id" value="<?= $param['cart_id']; ?>">
                                    <td class="thumbnail-img">
                                        <a href="#">
									<img class="img-fluid" src="images/img-pro-01.jpg" alt="" />
								</a>
                                    </td>
                                    <td class="name-pr">
                                        <a href="#">
									<?=$param['product_name'];?>
								</a>
                                    </td>
                                    <td class="price-pr">
                                        <p>$ <?=$param['cost'];?></p>
                                    </td>
                                    <td class="quantity-box"><input type="text" class="count" value ="<?=$param['count']?>" name="count", id="count"></td>
                                    
                                    <td class="total-pr">
                                        <p ><span class="cost">$ <?=$param['cost']*$param['count']?></span></p>
                                    </td>
                                    <td class="remove-pr">
                                        <?=Html::a('<i class="fas fa-sync-alt"></i>',['cart']);?>

                                    
                                
                                    </td>
                                    <td class="remove-pr">
                                        <?=Html::a('<i class="fas fa-times"></i>', ['delete', 'id' => $param['cart_id']]);?>
									
								
                                    </td>
                                </tr>
                                 
                            <?php } ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-6 col-sm-6">
                    <div class="coupon-box">
                        <div class="input-group input-group-sm">
                            <input class="form-control" placeholder="Enter your coupon code" aria-label="Coupon code" type="text">
                            <div class="input-group-append">
                                <button class="btn btn-theme" type="button">Apply Coupon</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="update-box">
                        <input value="Update Cart" type="submit">
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <h3>Order summary</h3>
                        <div class="d-flex">
                            <h4>Sub Total</h4>
                            <div class="ml-auto font-weight-bold"> $ <?=$cost?></div>
                        </div>
                        <div class="d-flex">
                            <h4>Discount</h4>
                            <div class="ml-auto font-weight-bold"> $ <?=$discount?> </div>
                        </div>
                        <hr class="my-1">
                        <div class="d-flex">
                            <h4>Coupon Discount</h4>
                            <div class="ml-auto font-weight-bold"> $ 10 </div>
                        </div>
                        <div class="d-flex">
                            <h4>Tax</h4>
                            <div class="ml-auto font-weight-bold"> $ 2 </div>
                        </div>
                        <div class="d-flex">
                            <h4>Courier</h4>
                            <div class="ml-auto font-weight-bold"><input id="shipping" type="checkbox" /></div>
                        </div>
                        <div class="d-flex">
                            <h4>Shipping Cost</h4>                                                
                            <div class="ml-auto font-weight-bold"> <?=$shipping?> </div>
                        </div>
                        <hr>
                        <div class="d-flex gr-total">
                            <h5>Grand Total</h5>
                            <div class="ml-auto h5"> $ <?=$totalcost?> </div>
                        </div>
                        <hr> </div>
                </div>
                <div class="col-12 d-flex shopping-box">
                    <?= Html::a('Checkout', ['site/buy','totalcost'=>$totalcost], ['class' => 'ml-auto btn hvr-hover']) ?> </div>
            </div>

        </div>
    </div>
   