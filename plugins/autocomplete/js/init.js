 $.widget("custom.catcomplete", $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
		var self = this,
			division = "";
		$.each( items, function( index, item ) {
			if ( item.division != division ) {
				if(item.division=="Potri"){
				ul.append( "<li  class='ui-autocomplete-category'><a href='genesearch?term="+item.division+"'><strong>Eucalyptus grandis</strong></a></li>" );

				}else if(item.division=="Potra"){
				ul.append( "<li  class='ui-autocomplete-category'><a href='genesearch?term="+item.division+"'><strong>Populus tremula</strong></a></li>" );

					}else if(item.division=="Potrs"){
				ul.append( "<li  class='ui-autocomplete-category'><a href='genesearch?term="+item.division+"'><strong>Populus tremuloides</strong></a></li>" );

					}else if(item.division=="Potrx"){
				ul.append( "<li  class='ui-autocomplete-category'><a href='genesearch?term="+item.division+"'><strong>Populus tremuloides x Populus tremula-T89</strong></a></li>" );

					}
				division = item.division;
			}

			self._renderItemData( ul, item );
		});
		},
		_renderItem : function( ul, item ) {

 item.labelr = item.labelr.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<font color='#FF0000' size='2'>$1</font>");

		return $("<li></li>")
       .data("item.autocomplete", item)
     //   .append("<a><div ><div '>" + item.labelr + " - <font color='#333' size='2'>" + item.value +"</font></div></div></a>")
	  .append("<a><div ><div '>" + item.labelr + "</div></div></a>")
        .appendTo(ul);

    }

	});

   $(function() {

    $( "#mainsearch" ).catcomplete({
      source: function( request, response ) {
        $.ajax({
          url: "plugins/autocomplete/service/autocomplete.php",
          dataType: "json",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
				labelr: item.trinityname2x,
                label: item.trinityname,
                value: item.taxonomyname,
				division: item.division
              }
            }));
          }
        });
      },
      minLength: 2,
        select: function( event, ui ) {
		  console.log(ui.item)
		  document.getElementById('mainsearch').value=ui.item.label;
		    var res = ui.item.label.split("-");
		  if(ui.item.label.substring(0,2)=="MA" || ui.item.label.substring(0,2)=="PI"){
		  window.location = "gene?id="+res[0];
			  }else{
		  window.location = "gene?id="+res[0];
			  }
		  return false;

        }

    })
  });



	function myFunction(x)
		{
		if( x.value.length!=0){
			document.getElementById('mainsearch').style.width='274px';
			}else{
			//document.getElementById('mainsearch').style.width='24px';	 width="135" height="152"
			}
		}

		function searchenter(myfield,e)
		{
			var keycode;
			if (window.event) keycode = window.event.keyCode;
			else if (e) keycode = e.which;
			else return true;

			if (keycode == 13)
			   {
				// window.location = "genesearch?term="+myfield.value;
				 window.location = "?_term="+myfield.value+"&genelist=enable";

			   return false;
			   }
			else
			   return true;
		}