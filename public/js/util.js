var _____WB$wombat$assign$function_____ = function(name) {return (self._wb_wombat && self._wb_wombat.local_init && self._wb_wombat.local_init(name)) || self[name]; };
if (!self.__WB_pmw) { self.__WB_pmw = function(obj) { this.__WB_source = obj; return this; } }
{
  let window = _____WB$wombat$assign$function_____("window");
  let self = _____WB$wombat$assign$function_____("self");
  let document = _____WB$wombat$assign$function_____("document");
  let location = _____WB$wombat$assign$function_____("location");
  let top = _____WB$wombat$assign$function_____("top");
  let parent = _____WB$wombat$assign$function_____("parent");
  let frames = _____WB$wombat$assign$function_____("frames");
  let opener = _____WB$wombat$assign$function_____("opener");

const dragonUtil = (function ($) {
	let started = false;
	
	function init() {
		if (started) {
			return;
		}
		
		started = true;
		
		$('.dragon-check-all').click(event => {
			checkAll(event.target.checked);
		});
		
		$('.check-me').click(event => {
			checkOne(event.target);
		});
		
		handleAdminTableSorting();
		handleAccordion();
	}
	
	function getUrlParam(param) {
	    const url = window.location.search.substring(1);
	    const urlVars = url.split('&');
	    let paramName = null;
	
	    for (let i = 0; i < urlVars.length; i++) {
	        paramName = urlVars[i].split('=');
	
	        if (paramName[0] === param) {
	            return paramName[1] === undefined ? true : decodeURIComponent(paramName[1]);
	        }
	    }

		return null;
	};
	
	// Privates
	
	function handleAccordion() {
		var acc = document.getElementsByClassName("dragon-accordion");
		var i;
		
		for (i = 0; i < acc.length; i++) {
		  acc[i].addEventListener("click", function(event) {
			event.preventDefault();
		    this.classList.toggle("active");
		    var panel = this.nextElementSibling;
		    if (panel.style.display === "block") {
		      panel.style.display = "none";
		    } else {
		      panel.style.display = "block";
		    }
		  });
		}
	}
	
	function handleAdminTableSorting() {
		let el = document.getElementById('dragon-drop');
		if (el == null) {
			return;
		}
		
		let sortable = Sortable.create(el, {
			handle: '.dragon-drop-handle',
			animation: 150,
			onUpdate: event => {
				let data = {
					'action': 'dragon_set_table_sorting',
					'order': sortable.toArray(),
					'page_slug': getUrlParam('page'),
				};
				
				$.post(ajax_url, data);
			}
		});
	}
	
	function checkAll(shouldCheck) {
		let ids = [];
		$('.check-me').each((index, element) => {
			if (shouldCheck === false) {
				element.checked = false;
			} else {
				element.checked = true;
				ids[ids.length] = $(element).val();
			}
		});
		$('.action-ids').val(ids.join());
	}
	
	function checkOne(element) {
		let existingIds = $('.action-ids').val();
		let ids = existingIds.length === 0 ? [] : $('.action-ids').val().split(',');
		let currentId = $(element).val();
		
		if (element.checked) {
			ids[ids.length] = currentId;
		} else {
			let index = ids.indexOf(currentId);
			if (index > -1) {
				ids.splice(index, 1);
			}
		}
		
		$('.action-ids').val(ids.join());
	}
	
	return { init, getUrlParam };
})(jQuery);

jQuery(document).ready(() => {
	dragonUtil.init();
});


}
/*
     FILE ARCHIVED ON 00:26:00 Apr 13, 2024 AND RETRIEVED FROM THE
     INTERNET ARCHIVE ON 13:10:53 Sep 04, 2024.
     JAVASCRIPT APPENDED BY WAYBACK MACHINE, COPYRIGHT INTERNET ARCHIVE.

     ALL OTHER CONTENT MAY ALSO BE PROTECTED BY COPYRIGHT (17 U.S.C.
     SECTION 108(a)(3)).
*/
/*
playback timings (ms):
  captures_list: 0.61
  exclusion.robots: 0.034
  exclusion.robots.policy: 0.022
  esindex: 0.012
  cdx.remote: 29.856
  LoadShardBlock: 79.612 (3)
  PetaboxLoader3.datanode: 140.38 (5)
  load_resource: 332.672 (2)
  PetaboxLoader3.resolve: 195.059 (2)
*/