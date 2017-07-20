<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 19.07.2017
 * Time: 12:51
 */

namespace app\models;


use yii\base\Model;

class Cart extends Model
{

    public function addToCart($product, $qty = 1)
    {
        if (isset($_SESSION['cart'][$product['id']]))
            $_SESSION['cart'][$product['id']]['qty'] += $qty;
        else {
            $_SESSION['cart'][$product['id']] = [
                'qty' => $qty,
                'title' => $product['title'],
                'price' => $product->price['priceOut']
            ];
        }
        $_SESSION['cart']['qty'] = isset($_SESSION['cart']['qty']) ? $_SESSION['cart']['qty'] + $qty : $qty;
        $_SESSION['cart']['sum'] = isset($_SESSION['cart']['sum']) ? $_SESSION['cart']['sum'] + $qty * $product->price['priceOut'] : $qty * $product->price['priceOut'];
    }

    public function setQuantity($id,$quantity){
        if (isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['qty'] = $quantity;
            $this->reCalcTotal();
        }
    }

    public function deleteCart($id){
        if (isset($_SESSION['cart'][$id])){
            unset($_SESSION['cart'][$id]);
            $this->reCalcTotal();
        }
//        if($_SESSION['cart']['qty']==0)
//            unset($_SESSION['cart']);
    }

    private function reCalcTotal(){
        if(!empty($_SESSION['cart'])){

            $sum=0;
            $qty=0;

            foreach ($_SESSION['cart'] as $id => $item){
                $sum +=$item['price'] * $item['qty'];
                $qty +=$item['qty'];
            }

            $_SESSION['cart']['qty'] = $qty;
            $_SESSION['cart']['sum'] = $sum;

        }
    }

}