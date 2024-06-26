$(window).on("load", function () {
	$(document).on("click", ".toggle-password", function () {
        
        $(this).toggleClass('icon-eye');
		$(this).toggleClass('icon-eye-slash');

        var passwordInput = $(this).siblings('.password-input');
        if(passwordInput.attr('type') === 'password'){
            passwordInput.attr('type', 'text'); 
        }else{
            passwordInput.attr('type', 'password');
        }
	});
	/*_____ Header Toggle _____*/
	$(document).on("click", "header .toggle", function () {
		$("header .toggle").toggleClass("active");
		$("html").toggleClass("flow");
		$("nav").toggleClass("active");
	});
	$(document).on("click", "nav .x_btn, nav .run_btn", function () {
		$("header .toggle").removeClass("active");
		$("html").removeClass("flow");
		$("nav").removeClass("active");
	});

	/*_____ Toggle Button _____*/
	$(document).on("click", "aside .toggle", function () {
		$(this).toggleClass("active");
		w = $(window).width();
		if (w >= 1024) {
			$("body").toggleClass("move");
		} else {
			$("html").toggleClass("flow");
			$("nav").toggleClass("active");
		}
	});

	/*_____ Drop Down _____*/
	$(document).on("click", ".drop_btn", function (e) {
		e.stopPropagation();
		if ($(this).parents(".drop_cnt:first").hasClass("active")) $(this).parents(".drop_cnt:first").find(".drop_cnt:first").addClass("active");
		else {
			$(".drop_cnt").not($(this).parent().children(".drop_cnt")).removeClass("active");
			$(this).parents(".drop_down:first").find(".drop_cnt:first").toggleClass("active");
		}
	});
	$(document).on("click", ".drop_cnt", function (e) {
		e.stopPropagation();
	});
	$(document).on("click", function () {
		$(".drop_cnt").removeClass("active");
	});

	/*_____ Popup _____*/
	$(document).on("click", ".popup", function (e) {
		if ($(e.target).closest(".popup ._inner, .popup .inside").length === 0) {
			$(".popup").fadeOut("3000");
			$("html").removeClass("flow");
			$("#vid_blk > iframe").attr("src", "");
		}
	});
	$(document).on("click", ".popup .x_btn", function () {
		$(".popup").fadeOut();
		$("html").removeClass("flow");
		$("#vid_blk > iframe").attr("src", "");
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 27) $(".popup .x_btn").click();
	});
	$(document).on("click", ".pop_btn", function () {
		var popUp = $(this).data("popup");
		$("html").addClass("flow");
		$(".popup[data-popup= " + popUp + "]").fadeIn();
	});
	$(document).on("click", ".pop_btn[data-src]", function () {
		var src = $(this).data("src");
		$("#vid_blk > iframe").attr("src", src);
	});

	/*_____ QTY Button _____*/
	$(document).on("click", ".qty_plus", function (e) {
		e.preventDefault();
		var parent = $(this).parent().children(".qty");
		var currentVal = parent.val();
		if (!isNaN(currentVal)) {
			let incrementedVal = parseInt(currentVal) + 1;
			parent.val(incrementedVal);
		} else {
			parent.val(1);
		}
	});
	$(document).on("click", ".qty_minus", function (e) {
		e.preventDefault();
		var parent = $(this).parent().children(".qty");
		var currentVal = parent.val();
		if (!isNaN(currentVal) && currentVal > 1) {
			let decrementedVal = parseInt(currentVal) - 1;
			parent.val(decrementedVal);
		} else {
			parent.val(1);
		}
	});

	/*_____ FAQ's _____*/
	$(document).on("click", ".faq_blk > h5", function () {
		$(".faq_blk").not($(this).parent().toggleClass("active")).removeClass("active");
		$(".faq_blk > .txt").not($(this).parent().children(".txt").slideToggle()).slideUp();
	});
	$(".faq_lst > .faq_blk:nth-child(1)").addClass("active");

	/*_____ Wallet Block _____*/
	$(document).on("change", "[data-payment='wallet'] .lbl_btn > input.tglBlk", function () {
		let checked = this.checked;
		if (checked == true) {
			$(this).parents("[data-payment='wallet']").find(".inside_blk").slideToggle();
		} else $(this).parents("[data-payment='wallet']").find(".inside_blk").slideUp();
	});

	/*_____ Fieldset Button _____*/
	$(".next_btn").click(function () {
		currStep = $(this).parents("fieldset");
		nextStep = currStep.next("fieldset");
		currStep.hide();
		nextStep.fadeIn();
	});
	$(".prev_btn").click(function () {
		currStep = $(this).parents("fieldset");
		prevStep = currStep.prev("fieldset");
		currStep.hide();
		prevStep.fadeIn();
	});

	/*_____ Run Button _____*/
	$(document).on("click", ".run_btn", function (event) {
		if (this.hash !== "") {
			event.preventDefault();
			var hash = this.hash;
			console.log(hash);
			$("html, body").animate(
				{
					scrollTop: $(hash).offset().top - 20,
				},
				800
			);
		}
	});

	/*_____ Like Button _____*/
	$(document).on("click", ".ico_btn > a.like_btn", function () {
		$(this).toggleClass("liked");
	});

	/*_____ Upload Block _____*/
	$(document).on("click", ".upload_blk > button", function () {
		$(this).parent().children("input[type='file']").trigger("click");
	});
	$(document).on("change", "input[type='file']", function () {
		let file = $(this).val();
		if (this.files.length > 0) {
			$(this).parent(".upload_blk").children("button").text(file);
		} else {
			$(this).parent(".upload_blk").children("button").text("Choose File");
		}
	});

	/*_____ Shop Settings _____*/
	$(document).on("click", "#shop_set .add_btn", function () {
		$(this).parent().children(".text_box").slideDown();
	});

	/*_____ Bar List _____*/
	function list() {
		veh_01 = $("#bar .list>ul>li:nth-child(1)>a").text();
		console.log(veh_01);
		veh = $("#bar .list>ul>li.active>a").text();
		$("#bar .list>span").text(veh);
		if ($("#bar .list>ul>li").hasClass("active")) {
			$("#bar .list").children("span").text(veh);
		} else {
			$("#bar .list").children("span").text(veh_01);
		}
	}
	list();
	$(document).on("click", "#bar .list>strong", function () {
		w = $(window).width();
		if (w <= 1024) {
			$(this).parent().toggleClass("active");
		}
	});

	/*_____ Data Option _____*/
	$(document).on("change", "[data-option] > label > input", function () {
		let opt = $(this).parents("[data-option]").attr("data-option");
		let id = $(this).attr("id");
		console.log(opt);
		// let checked = $(this).checked;
		$("[data-option='" + opt + "']")
			.children("[data-id]")
			.slideUp();
		$("[data-option='" + opt + "']")
			.children("[data-id='" + id + "']")
			.slideDown();
	});

	/*_____ Footer _____*/
	$(document).on("click", "footer h4.drop", function () {
		w = $(window).width();
		if (w <= 991) {
			$(this).next(".list").slideToggle();
		}
	});

	/*___________________________________ Main JS WORK ___________________________________*/

	/*_____ Selectpicker _____*/
	if ($('.selectpicker').length > 0) {
		$(".selectpicker").selectpicker();
	}	
	/*_____ Slick Carousel _____*/
	if($("[data-id='slick-listing']").length > 0){
		$("[data-id='slick-listing']").slick({
			dots: true,
			arrows: true,
			infinite: true,
			speed: 1000,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1026,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 2,
					},
				},
				{
					breakpoint: 580,
					settings: {
						slidesToShow: 1,
					},
				},
			],
		});
	}
	
	if($("#slick-slider").length > 0){
		$("#slick-slider").slick({
			arrows: true,
			infinite: true,
			speed: 1000,
			slidesToShow: 1,
			slidesToScroll: 1,
			asNavFor: "#slick-thumbs",
		});
	}
	
	if($("#slick-thumbs").length > 0){
		$("#slick-thumbs").slick({
			dots: false,
			arrows: false,
			centerMode: true,
			focusOnSelect: true,
			slidesToShow: 5,
			slidesToScroll: 1,
			asNavFor: "#slick-slider",
			responsive: [
				{
					breakpoint: 580,
					settings: {
						slidesToShow: 3,
					},
				},
			],
		});
	}
	
	if($("#slick-pricing").length > 0){
		$("#slick-pricing").slick({
			dots: false,
			arrows: true,
			slidesToShow: 3,
			slidesToScroll: 1,
			variableWidth: true,
			responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 769,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
		});
	}
	
	if($("#slick-vendors").length > 0){
		$("#slick-vendors").slick({
			dots: false,
			arrows: true,
			infinite: true,
			speed: 1000,
			slidesToShow: 5,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1026,
					settings: {
						slidesToShow: 4,
					},
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 580,
					settings: {
						slidesToShow: 2,
					},
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
					},
				},
			],
		});
	}
	
	if($("#slick-listing, #slick-choose, #slick-dealer").length > 0){
		$("#slick-listing, #slick-choose, #slick-dealer").slick({
			dots: true,
			arrows: true,
			infinite: true,
			speed: 1000,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1026,
					settings: {
						slidesToShow: 2,
					},
				},
				{
					breakpoint: 580,
					settings: {
						slidesToShow: 1,
					},
				},
			],
		});
	}
	

	/*_____ Rateyo _____*/
	if($(".rateYo").length > 0){
		$(".rateYo").rateYo({
			rating: 4.0,
			fullStar: true,
			readOnly: true,
			normalFill: "#ddd",
			ratedFill: "#ffc000",
			starWidth: "16px",
			spacing: "2px",
		});
	}
	

	/*_____ Datepicker _____*/
	if($(".datepicker").length > 0){
		$(".datepicker").datepicker({
			// multidate: true,
			format: "mm-dd-yyyy",
			todayHighlight: true,
			multidateSeparator: ",  ",
		});
	}
	
});
