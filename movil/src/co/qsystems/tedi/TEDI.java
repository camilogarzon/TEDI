package co.qsystems.tedi;

import org.apache.cordova.*;

import android.os.Bundle;

public class TEDI extends DroidGap
{
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        super.loadUrl("file:///android_asset/www/index.html");
    }
}

