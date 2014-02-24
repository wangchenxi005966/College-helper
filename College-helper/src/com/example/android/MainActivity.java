package com.example.android;

import org.apache.cordova.DroidGap;
import com.example.android.MainActivity;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;

public class MainActivity extends DroidGap {

	private int first_login = 0;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		super.setIntegerProperty("splashscreen", R.drawable.splash);
		if (checkNetWorkStatus()) {
			if (checkFirstLogin()) {
				super.loadUrl("file:///android_asset/www/index_1.html", 4000);
			} else {
				super.loadUrl("file:///android_asset/www/index.html", 4000);
			}
		}
	}

	boolean checkFirstLogin() {
		SharedPreferences Settings = getPreferences(Activity.MODE_PRIVATE);
		first_login = Settings.getInt("first_login", 0);
		Editor edit = Settings.edit();// 获得编辑器
		if (first_login == 0) {
			edit.putInt("first_login", 1);
			edit.commit();
			return true;
		} else {
			first_login++;
			edit.putInt("first_login", first_login);
			edit.commit();
			return false;
		}

	}

	boolean checkNetWorkStatus() {
		boolean result;
		ConnectivityManager cm = (ConnectivityManager) this
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo netinfo = cm.getActiveNetworkInfo();
		if (netinfo != null && netinfo.isConnected()) { // 当前网络可用
			result = true;
		} else { // 不可用
			new AlertDialog.Builder(MainActivity.this)
					.setMessage("检查到没有可用的网络连接,请打开网络连接")
					.setPositiveButton("确定",
							new DialogInterface.OnClickListener() {
								public void onClick(
										DialogInterface dialoginterface, int i) {
									ComponentName cn = new ComponentName(
											"com.android.settings",
											"com.android.settings.Settings");
									Intent intent = new Intent();
									intent.setComponent(cn);
									intent.setAction("android.intent.action.VIEW");
									startActivity(intent);
									finish();
								}
							}).show();
			result = false;
		}
		return result;
	}
}
