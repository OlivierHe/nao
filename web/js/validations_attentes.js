     function initMap(latLong)
	{
		if (typeof latLong !== 'undefined') {
			var lat = parseFloat(latLong[0]);
			var long = parseFloat(latLong[1]);
		    var myLatLng = new google.maps.LatLng(lat,long);
		    
		    var map = new google.maps.Map(document.getElementById("map"),
		    {
		        center: myLatLng,
		        zoom: 15
		    });

		    var marker = new google.maps.Marker(
		    {
		        position: myLatLng,
		        map: map,
	            animation: google.maps.Animation.DROP
		    });
            

		}
	}



$(document).ready(function() {
	       // ouvre un modale photo quand button photo clické
      $('#obs tbody').on( 'click', '.btn-photo', function () {
      	   var photo = $(this).data("photo");
  	       $('#photo-preview').attr("src", "photos/" + photo);
           $('#modal1').modal();
        } );

         // ouvre une modale google map quand lien carte cliqué
        $('#obs tbody').on( 'click', '.map_link', function () {
      	   var latLong = $(this).data("latlong");
      	   var result = latLong.split(",");
  	       //initMap(result);
           $('#modal2').modal({
           		ready: function() { 
   			 	    initMap(result);
           			google.maps.event.trigger(map, "resize");
			    }
           });   
        } );
 
	} );

// début select 2
   var taxrefId;  
  

     $('select').on('select2:select', function (evt) {
       var select2Obj = $(".js-data-example-ajax").select2('data');
       selectObj = select2Obj[0].nomRef
     });

   function formatAllRepo (repo){
   	  if (repo.id ==='') return "<i class='petite material-icons' style='vertical-align: middle'>search</i> Modifier l'espece";
   	  if (repo.nomVern === '') repo.nomVern = "Pas de nom vernaculaire";
      var markup = " <i class='fa fa-twitter' aria-hidden='true'></i> "
      				 + repo.nomVern
      				 + " <i class='tiny material-icons' style='vertical-align: middle'>assignment</i> "
      				 +  repo.nomRef ;
      return markup;
   } 

   function formatRepo (repo) {
		if (repo.loading) return  '<div class="progress  light-blue accent-4" id="loader"> <div class="indeterminate  light-blue lighten-4"></div> </div>';
		return formatAllRepo(repo);
    }

    function formatRepoSelection (repo) {
		if (repo.id !=='') taxrefId = repo.id ; 
		return formatAllRepo(repo);
    }
