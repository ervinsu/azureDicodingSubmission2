<!DOCTYPE html>
<html>
<head>
    <title>Analyze Sample</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>

<body>

<h1>Analyze image:</h1>
Choose the image to be analyzed, then click the <strong>Analyze image</strong> button.
<br><br>
Image to analyze:
<!-- <input type="text" name="inputImage" id="inputImage"
    value="http://upload.wikimedia.org/wikipedia/commons/3/3c/Shaki_waterfall.jpg" />
<button onclick="processImage()">Analyze image</button> -->
<br>
<form action="index.php?Uploaded" method="POST" enctype="multipart/form-data">
  <input type="file" name="pic" accept="image/*">
  <input type="submit">
</form>


<br><br>
<div id="wrapper" style="width:1020px; display:table;">
    <div id="jsonOutput" style="width:600px; display:table-cell;">
        Response:
        <br><br>
        <H1 id="responseTextArea" class="UIInput"
                  style="width:580px; height:400px;"></H1>
    </div>
    <div id="imageDiv" style="width:420px; display:table-cell;">
        Source image:
        <br><br>
        <img id="sourceImage" width="400" />
    </div>
</div>

<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<script type="text/javascript">
    function processImage(pictureURL) {
        // **********************************************
        // *** Update or verify the following values. ***
        // **********************************************
 
        // Replace <Subscription Key> with your valid subscription key.
        var subscriptionKey = "1c344410693342a1966d9096f0a1001f";
 
        // You must use the same Azure region in your REST API method as you used to
        // get your subscription keys. For example, if you got your subscription keys
        // from the West US region, replace "westcentralus" in the URL
        // below with "westus".
        //
        // Free trial subscription keys are generated in the "westus" region.
        // If you use a free trial subscription key, you shouldn't need to change
        // this region.
        var uriBase =
            "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
 
        // Request parameters.
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };
 
        // Display the image.
        // var sourceImageUrl = document.getElementById("inputImage").value;
        // document.querySelector("#sourceImage").src = sourceImageUrl;
 
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
 
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader(
                    "Ocp-Apim-Subscription-Key", subscriptionKey);
            },
 
            type: "POST",
 
            // Request body.
            data: '{"url": ' + '"' + pictureURL + '"}',
        })
 
        .done(function(data) {
            // Show formatted JSON on webpage.
            var json = JSON.stringify(data, null, 2);
            var jsonData = JSON.parse(json);
            document.getElementById("responseTextArea").innerHTML = jsonData.description.captions[0].text;
        })
 
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    };


    function showImage(input){
       
		 if (input.files && input.files[0]) {
            var reader = new FileReader();
            console.log("test");
            reader.onload = function (e) {
                $('#sourceImage')
                    .attr('src', e.target.result)
                    .width(400);
            };

            reader.readAsDataURL(input.files[0]);
        }
    } 

     function showImageJS(input){
       
		 var image = document.getElementById("sourceImage");
		image.src = "uploads/test.jpg";
    }    

</script>

	<?php
		require_once 'upload.php';

		if (!isset($_GET["Uploaded"])) {
			?>
			<!-- 	<script type="text/javascript">alert("Page is unloaded");
						// var pictaken = "uploads/test.jpg";
						// document.getElementById('sourceImage').src=pictaken;
				</script>  -->
		    <?php
		}else{
			if(isset($_GET["pic"]))
						echo basename($_FILES['pic']['name']);
						$target = 'uploads/'.basename($_FILES['pic']['name']);
						move_uploaded_file($_FILES['pic']['tmp_name'],$target);
						$Linknya = uploadFile(basename($_FILES['pic']['name']), 'uploads/'.basename($_FILES['pic']['name'])); ?>
					<script type="text/javascript">
						// alert("Page is loaded to <?php echo $Linknya?>");
						var pictaken = "<?php echo 'uploads/'.basename($_FILES['pic']['name']);?>";
						showImageJS(pictaken);
						var picUploaded = "<?php echo $Linknya?>";
						processImage(picUploaded);
					</script>
			<?php
			}	
	?>  	
</body>
</html>