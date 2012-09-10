<?php
class Post_Task
{
	function ping()
	{
		Bundle::start('mongor');

		$data['post'] = Post::sort(['created_at'=>-1])->first();

		echo "Pinging Post: ";

		try {
			if (!$data['post']->exists) {
				throw new Exception("No post to ping");
			}

			$xmlrpcReq = View::make('tools.ping',$data)->render();

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_USERAGENT, IoC::resolve('site')->name.' Agent');
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlrpcReq);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
			curl_setopt($curl, CURLOPT_URL, "http://rpc.pingomatic.com/");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$pingresponse = curl_exec($curl);
			$http_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
			$error_num = curl_errno($curl);
			$error_message = curl_error($curl);

			if ($http_code != 200 or $error_num != 0) {
				throw new Exception("Failed to ping post: ".$error_message);
			}

			echo "Done\n";
			echo $pingresponse."\n";
			Log::ping('Successfully pinged post.');
		} catch (Exception $e) {
			echo "Failed\n";
			echo $e->getMessage()."\n";
			Log::exception($e);
		}
	}
}