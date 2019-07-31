

@extends("dashboard.template")

@section("content")

<style> .error { background: #FF98A0 ; } </style>

<script src="{{asset('js/crop.js')}}"></script>
<link href="{{asset('css/crop.css')}}" rel="stylesheet">

<script type="text/javascript">

  jQuery(function($){

    // Create variables (in this scope) to hold the API and image size
    var jcrop_api,
        boundx,
        boundy,

        // Grab some information about the preview pane
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),

        xsize = $pcnt.width(),
        ysize = $pcnt.height();
    
    console.log('init',[xsize,ysize]);


    $('#target').Jcrop({
      onChange: updatePreview,
      onSelect: updatePreview,
      aspectRatio: xsize / ysize,
      setSelect : [0,0,200,0],
      boxWidth: 450, boxHeight: 600
    },function(){
      // Use the API to get the real image size
      var bounds = this.getBounds();
      boundx = bounds[0];
      boundy = bounds[1];
      // Store the API in the jcrop_api variable
      jcrop_api = this;

      // Move the preview into the jcrop container for css positioning
      $preview.appendTo(jcrop_api.ui.holder);
    });

    function updatePreview(c)
    {
    
        $("#width").val(c.w) ; 
        $("#height").val(c.h) ; 
        $("#x").val(c.x) ; 
        $("#y").val(c.y) ; 

        if (parseInt(c.w) > 0)
        {
            var rx = xsize / c.w;
            var ry = ysize / c.h;

            var width = Math.round(rx * boundx); 
            var height = Math.round(ry * boundy); 
            var left = Math.round(rx * c.x); 
            var top = Math.round(ry * c.y); 

            $pimg.css({
              width: width+"px",
              height: height+"px",
              marginLeft: "-"+left+"px",
              marginTop: "-"+top+"px"
            });
        }
    };

  });


</script>

<style type="text/css">

    .jcrop-holder #preview-pane 
    {
      display: block;
      position: absolute;
      z-index: 2000;
      top: 60px;
      right: -280px;
      padding: 6px;
      border: 1px rgba(0,0,0,.4) solid;
      background-color: white;
    }

    #preview-pane .preview-container 
    {
      width: 250px;
      height: 350px;
      overflow: hidden;
    }

</style>

<div class="container-fluid">
    <div class="row">


        <form action='{{url("dashboard/product/crop/$product->id")}}' method="POST">
            <div style="float:left;">
                @csrf         
                <img src="{{url('')}}/storage/product/{{$product->image}}" id="target" />

                <div id="preview-pane">
                  <div class="preview-container">
                    <img src="{{url('')}}/storage/product/{{$product->image}}" class="jcrop-preview" />
                  </div>
                </div>
            </div>

            <input type="hidden" name="height" id="height">
            <input type="hidden" name="width" id="width">
            <input type="hidden" name="x" id="x">
            <input type="hidden" name="y" id="y">
            <input type="hidden" name="id" value="{{$product->id}}">

            <div style="float: right; margin-left: 20px">
                <a><button type="submit" class="btn btn-success" id="submit">submit</button></a>
            </div>
        </form>

    	

    </div>
</div>
@endsection