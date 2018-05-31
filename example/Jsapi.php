<?php 
namespace wxpay\example;

//error_reporting(E_ERROR);
require_once(EXTEND_PATH.'wxpay/lib/WxPay.Api.php');
require_once(EXTEND_PATH.'wxpay/example/WxPay.JsApiPay.php');


class Jsapi 
{
	//打印输出数组信息
	public function pay($openId,$body,$order_num,$total)
	{
		//①、获取用户openid
		$tools = new \JsApiPay();
		//$openId = $tools->GetOpenid();
		
		//如果有openid直接这一步
		//$openId = 'ogJHl5RVvz5IEnPYzm7IVjnG62h8';
		//$openId = $_POST['openid'];


		//②、统一下单
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($body);									//商品名称
		$input->SetAttach($body);								//设置附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据	
		$input->SetOut_trade_no($order_num); //订单号应该是由小程序端传给服务端的，在用户下单时即生成，demo中取值是一个生成的时间戳
		$input->SetTotal_fee($total);								//总价格，单位为分
		$input->SetTime_start(date("YmdHis"));					//订单生成时间
		$input->SetTime_expire(date("YmdHis", time() + 600));	//订单失效时间
		//$input->SetGoods_tag("test");			商品优惠券
		$input->SetNotify_url("https://ln.hongmaiwang.com/index/api/appNotify");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = \WxPayApi::unifiedOrder($input);
		//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
	//	print_r($order);

		$jsApiParameters = $tools->GetJsApiParameters($order);
		print_r($jsApiParameters);
		//获取共享收货地址js函数参数
		//$editAddress = $tools->GetEditAddressParameters();

		//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
		/**
		 * 注意：
		 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
		 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
		 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
		 */	
	}
}

?>


