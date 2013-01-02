<?
require_once('cumbari.php');
echo $lat=$_GET['lat'];
echo $lang=$_GET['lang'];
echo $zoom=$_GET['zoom'];
die();
if($lat!="" && $lang!="" && $zoom!="")
	 {
	 ?>
<script src="http://maps.google.com/maps?file=api&v=2&key=<?=_GKEY_?>" type="text/javascript"></script><style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}

-->
</style>
	 
	 <div class="center">
      <div class="right-detail-div">
        <div class="right-subheader-txt">Google Map</div>
        <div class="gmap">
		
		 <div align="center" style="margin:0;padding:0;margin-top:10px;">
        <div id="e2s_geo_map" style="margin:0;padding:0;width:490px;height:500px"></div>
      </div>
   
		   <script type='text/javascript'>//<![CDATA[
var tst_e2s_geo=document.getElementById('e2s_geo_map');
var tstint_e2s_geo;
var map_e2s_geo;


function CancelEvente2sGeoMap(event) { 
	var e = event; 
	if (typeof e.preventDefault == 'function') e.preventDefault(); 
	if (typeof e.stopPropagation == 'function') e.stopPropagation(); 
	
	if (window.event) { 
		window.event.cancelBubble = true; // for IE 
		window.event.returnValue = false; // for IE 
	} 
}

function Checke2sGeoMap()
{
	if (tst_e2s_geo) {
		if (tst_e2s_geo.offsetWidth != tst_e2s_geo.getAttribute("oldValue"))
		{
			tst_e2s_geo.setAttribute("oldValue",tst_e2s_geo.offsetWidth);

			if (tst_e2s_geo.getAttribute("refreshMap")==0)
				if (tst_e2s_geo.offsetWidth > 0) {
					clearInterval(tstint_e2s_geo);
					gete2sGeoMap();
					tst_e2s_geo.setAttribute("refreshMap", 1);
				} 
		}
		//window.top.document.forms.adminForm.elements.zoom.value = tstint_e2s_geo;
	}
}

function gete2sGeoMap(){
	if (tst_e2s_geo.offsetWidth > 0) {
		
	
		map_e2s_geo = new GMap2(document.getElementById('e2s_geo_map'));
		map_e2s_geo.addControl(new GMapTypeControl());
		map_e2s_geo.addControl(new GLargeMapControl());
		var overviewmap = new GOverviewMapControl();
		
		
		map_e2s_geo.setCenter(new GLatLng(<?=$lat?>, <?=$lang?>), <?=$zoom?>);
		map_e2s_geo.setMapType(G_NORMAL_MAP);
		map_e2s_geo.enableContinuousZoom();
		map_e2s_geo.enableDoubleClickZoom();
		map_e2s_geo.enableScrollWheelZoom();
		
		var point = new GPoint( <?=$lang?>, <?=$lat?>);
		var marker_e2s_geo = new GMarker(point, {title:"<?=$fetch_all['address1'].", ".$fetch_all['address2']?>"});
		map_e2s_geo.addOverlay(marker_e2s_geo);
		
		GEvent.addListener(marker_e2s_geo, 'click', function() {
			marker_e2s_geo.openInfoWindowHtml('<?=$fetch_all['address1'].", ".$fetch_all['address2']?>');
			});
			
		GEvent.addDomListener(tst_e2s_geo, 'DOMMouseScroll', CancelEvente2sGeoMap);
		GEvent.addDomListener(tst_e2s_geo, 'mousewheel', CancelEvente2sGeoMap);
	}
}
//]]></script>
      <script type="text/javascript">//<![CDATA[
if (GBrowserIsCompatible()) {
	tst_e2s_geo.setAttribute("oldValue",0);
	tst_e2s_geo.setAttribute("refreshMap",0);
	tstint_e2s_geo=setInterval("Checke2sGeoMap()",500);
}
//]]></script>
</div>
      </div></div>
  <? }
  else
  {
  	echo "Map not available.";
  }
  
   ?> 