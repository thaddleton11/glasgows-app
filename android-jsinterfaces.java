package org.glasgows.gemdemov1;

/**
 * Created by Tomh on 14/09/2016.
 */

import android.app.Activity;
import android.app.DownloadManager;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Environment;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.NotificationCompat;
import android.support.v4.content.ContextCompat;
import android.util.Log;
import android.webkit.DownloadListener;
import android.webkit.JavascriptInterface;
import android.webkit.WebView;
import android.widget.Toast;

import com.google.firebase.iid.FirebaseInstanceId;

import org.json.JSONException;
import org.json.JSONObject;


public class WebAppInterface extends Activity {

    private WebView webView;

    Context mContext = this;

    Activity activity;

    final int SELECT_PHOTO = 1;

    WebAppInterface(Context c) {
        mContext = c;
    }

    static final String ACTION_SCAN = "com.google.zxing.client.android.SCAN";

    private Class<?> mClss;

    // open qr code scanner intent
    @JavascriptInterface
    public String startScanning() throws JSONException {
        try {
            if (ContextCompat.checkSelfPermission(mContext, android.Manifest.permission.CAMERA)
                    != PackageManager.PERMISSION_GRANTED) {
                mClss = FullScannerFragmentActivity.class;

                ActivityCompat.requestPermissions(((Activity)mContext),
                        new String[]{android.Manifest.permission.CAMERA}, 1);
            } else {
                Intent intent = new Intent(mContext, FullScannerFragmentActivity.class);
                //mContext.startActivity(intent);
                ((Activity)mContext).startActivityForResult(intent, 0);
            }

        } catch (Exception e) {
            Log.d("Scanning", e.getMessage());

        }

        return;

    }

    // barcode scanner
    @JavascriptInterface
    public String startBarScanning() throws JSONException {

        try {
            if (ContextCompat.checkSelfPermission(mContext, android.Manifest.permission.CAMERA)
                    != PackageManager.PERMISSION_GRANTED) {
                mClss = FullScannerFragmentActivity.class;

                ActivityCompat.requestPermissions(((Activity)mContext),
                        new String[]{android.Manifest.permission.CAMERA}, 1);
            } else {
                Intent intent = new Intent(mContext, FullScannerFragmentActivity.class);
                //mContext.startActivity(intent);
                ((Activity)mContext).startActivityForResult(intent, 0);
            }

        } catch (Exception e) {
            Log.d("Scanning", e.getMessage());

        }

        return;

    }

    // return scanning result
    @JavascriptInterface
    public String scanningResult() throws JSONException {
        return WebViewActivity.scanned_result;
    }


    // prototype code for creating a contact card
    @JavascriptInterface
    public void startDownload(String jsonString) throws JSONException {

        webView.setDownloadListener(new DownloadListener() {
            public void onDownloadStart(String url, String userAgent,
                                        String contentDisposition, String mimetype,
                                        long contentLength) {
                DownloadManager.Request request = new DownloadManager.Request(
                        Uri.parse(url));

                request.allowScanningByMediaScanner();
                request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED);
                request.setDestinationInExternalPublicDir(Environment.DIRECTORY_DOWNLOADS, "Contact_Card.vcf");
                DownloadManager dm = (DownloadManager) mContext.getSystemService(Context.DOWNLOAD_SERVICE);

                dm.enqueue(request);
            }
        });

    }
}
