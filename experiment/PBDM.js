$(function () {
    function shuffle(o){ //v1.0
        for (var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
        return o;
    };

	var assignmentId = getUrlParameter('assignmentId')
	var turkSubmitTo = getUrlParameter('turkSubmitTo')
	var hitId = getUrlParameter('hitId')
	var workerId = getUrlParameter('workerId')

	var imageAddr = "http://www.kenrockwell.com/contax/images/g2/examples/31120037-5mb.jpg"; 
	var downloadSize = 4995374; //bytes
	var speedMbps = 0
		
    var LOGGER = "Logger.php";
    var GET_IMAGES = "GetImages.php"
    var IMAGE_GENERATOR = "Image.php";
    var SUBMIT_LOGGER = "SubmitImage.php";
    var SUBMIT_HIT = "SubmitHit.php";
	var GET_OFFER = "get_offer.php";
	var GET_EMAIL = "get_email.php";
	var GET_AD = "get_ad.php";
    var USER_IP = $("#ipAddress").text();
	

    // for (var i = 0; i < 10; i++) {
    //     $.get(IMAGE_GENERATOR, {"numberOfDotsMax" : 150, "numberOfDotsMin" : 50}).done(function(data) {
    //         console.log(data);
    //     });
    // }

    // TESTING
    // var NUMBER_OF_TEST_IMAGES = $("#numberOfTestImages").text();
    // var SECTION_SIZE = parseInt($("#sectionSize").text());

	var COUNTDOWN = 10;
	var PHASES = [2,2,2,2]
	var N_PHASES = 4;
	var EMAIL_ORDER = getEmailOrder()
	var CREDITS_PER_TASK =10;
	var CREDITS_PER_CENT = 10;

    // First two should be random follow by fixed 3
    var ORDERING = shuffle([1, 2]);

    // Section
    //     1: 2 guess
    //     2: Interval game

	var timer = 0;
	var jsLog = {};
	
	assign_globals();
    setup();
	
	var ads=false
	var with_timer=false
	var stage = 0;
	var stageRel=0;
	var currentPhase = 1;
    var totalCredits = 0;
	var emailType = "Spam";
	var max_credits = 0;
	var offer = 0;
	var assignment = true;
	
	function getEmailOrder(){
		email_order = {}
		for (var i=1;i<=N_PHASES;i++){
			var email_spam=[]
			var email_ham = []
			var N = PHASES[i-1]/2
			for (var j=1;j<=N;j++){email_spam.push([j,"spam"])}
			for (var j=1;j<=N;j++){email_ham.push([j,"ham"])}
			email_order["phase"+i]= shuffle(email_spam.concat(email_ham))	
		
		}
		return email_order
	}

	function assign_globals(){
		$(".n-phase1").text(PHASES[0])
		$(".n-phase2").text(PHASES[1])
		$(".n-phase3").text(PHASES[2])
		$(".n-phase4").text(PHASES[3])
		$(".n-seconds").text(COUNTDOWN)
		$(".credits-per-task").text(CREDITS_PER_TASK)

	}	
	

    /**
     * Sets up the function listeners and the hide / show states of various things.
     */


    function setup() {

        $("#submitFinal").click(submitAmazonId);
    	$("#spamButton").click(evaluateSpam);
		$("#hamButton").click(evaluateHam);
		$("#classifyButton").click(stageControler);
		
		$("#email-pre").hide();	
		$("#adsContainer").hide();
        $(".confidenceIntervalText").hide();
        $("#amazonId").hide();
        $("#submitFinal").hide();
        $("#surveyKeyText").hide();
        $("#surveyKey").hide();
        $("#questionText").hide();
        $("#questionTextTutorial").hide();
        $("#modal").modal({backdrop: 'static', keyboard: false});
        $("#modal").modal("show");
		$("#spamButton").hide();
		$("#hamButton").hide();
		$("#clock").hide();
		$("#form-bdm-tut").hide();
        $("#submitBdmBid-tut").hide();
		 MeasureConnectionSpeed()

		$("#instructions1Button").click(stageControler)
		$("#instructions2Button").click(stageControler)

		$("#submitBdmBid-tut").click(function(){
			max_credits = $("#inputBDM").val();
			$.ajax({
				type:'post',
  				url: GET_OFFER,
  				data: {data:JSON.stringify({alg:"bdm",max_p:CREDITS_PER_TASK})},
  				success:function(data){
					offer = parseInt(data)
					assignment = (max_credits>offer);
					runBDMtut()
						
					}
			});

		});	
		$("#submitBdmBid").click(function(){
			max_credits = $("#inputBDM").val();
			$.ajax({
				type:'post',
  				url: GET_OFFER,
  				data: {data:JSON.stringify({alg:"bdm",max_p:CREDITS_PER_TASK})},
  				success:function(data){
					offer = parseInt(data)
					assignment = (max_credits>offer);
					runPBDM();						
					}
			});

		});	

        $("#firstClose").click(function() {
			if (assignmentId=="ASSIGNMENT_ID_NOT_AVAILABLE"){
				alert("Please accept the HIT before you continue with the assignemnt")
			} else{
				$("#modal").modal("hide");
            	$("#demographics").modal({backdrop: 'static', keyboard: false});
            	$("#demographics").modal("show"); 

			}
			
        });
		$("#secondClose").click(function() {
			if (validate_dem()){
				log_demographics()
				$("#demographics").modal("hide");
			
            	$("#gameInstructions1").modal({backdrop: 'static', keyboard: false});
            	$("#gameInstructions1").modal("show");
				

			} else {
				alert("Please fill out all of the form correctly");
			}
		});

		

		
        log_user_info()
    }

	function stageControler(){
		if (stage<rel_phase(1)){
			updateCounter(1);
			setupPhase(1);		
			nextEmail();
		} else if (stage==rel_phase(1)){
			currentPhase=2
			updateCounter(2);
			setupPhase(2);
			$("#gameInstructions2").modal("show")
			$("#phase-credits").text(0)
			$("#instructions2Button").click(function(){
				with_timer = true
				nextEmail()
			});
		} else if (stage<rel_phase(2)){
			updateCounter(2);
			with_timer = true
			nextEmail();
		} else if (stage==rel_phase(2)){
			currentPhase=3
			updateCounter(3);
			$("#phase-credits").text(0)
			$("#gameInstructions3").modal("show");
			setupPhase(3);
		} else if (stage<rel_phase(3)){
			updateCounter(3);
			setupPhase(3);
		} else if (stage==rel_phase(3)){
			$("#phase-credits").text(0)
			currentPhase=4
			updateCounter(4);
			$("#gameInstructions4").modal("show")						
			setupPhase(4)
		} else if (stage<rel_phase(4)){
			updateCounter(4);
			if (assignment){
				with_timer=false;
				nextEmail();
			} else{
				with_timer=true;
				nextEmail();
			}

		} else {finish()}
	}

	function updateCounter(phase){
		$("#stageCounter").text(stage+1-rel_phase(phase-1));
		$("#current-phase").text(currentPhase);		
		stageRel = stage-rel_phase(phase-1);
	}

	function rel_phase(phase){
		var r_p = 0
		for (var i=0;i<phase;i++){
			r_p += PHASES[i];
		}
		return r_p;
	}

	function setupPhase(phase){
		switch(phase){
			case 1:
				
				
				$("#instructionsButton").click(function() {
            		$("#gameInstructions1").modal({backdrop: 'static', keyboard: false});
            		$("#gameInstructions1").modal("show");//instructionModal1
					$("#instructions1Button").unbind();
    			});
		
				$("#totalStages").text(PHASES[0]);
				$("#stageTitle").text("Phase 1: Untimed Classification");
				break;
			case 2:
				$("#instructionsButton").unbind()
				$("#instructionsButton").click(function() {
            		$("#gameInstructions2").modal({backdrop: 'static', keyboard: false});
            		$("#gameInstructions2").modal("show");
					$("#instructions2Button").unbind();
    			});
		
				$("#totalStages").text(PHASES[1]);
				$("#stageTitle").text("Phase 2: Timed Classification");
				break;
			case 3:
				$("#totalStages").text(PHASES[2]);
				$("#stageTitle").text("Phase 3: Price Mechanism")					
				$("#spamButton").hide();
				$("#hamButton").hide();
				$("#clock").hide();
				$("#submitBdmBid-tut").show();
				$("#form-bdm-tut").show();
				$("#email").hide();
				$("#adsContainer").hide();
				$("#instructionsButton").unbind()
				$("#instructionsButton").click(function() {
            		$("#gameInstructions3").modal({backdrop: 'static', keyboard: false});
            		$("#gameInstructions3").modal("show");
    			});

				break
			case 4:
				$("#totalStages").text(PHASES[3]);
				$("#stageTitle").text("Phase 4: Email Classification")					
				$("#spamButton").hide();
				$("#hamButton").hide();
				$("#clock").hide();
				$("#submitBdmBid").show();
				$("#form-bdm").show();
				$("#email").hide();
				$("#adsContainer").hide();
				$("#instructionsButton").unbind()
				$(".correct-timer").text(jsLog.credits.timer[1])
				$(".correct-no-timer").text(jsLog.credits.no_timer[0])
				$("#instructionsButton").click(function() {
            		$("#gameInstructions4").modal({backdrop: 'static', keyboard: false});
            		$("#gameInstructions4").modal("show");
    			});
				break

		}
		
	}

	function finish(){

		var totalCents = (Math.max(0,jsLog.credits.totalCredits)/CREDITS_PER_CENT)+1
		$("#finalModal").modal({backdrop: 'static', keyboard: false});
        $("#finalModal").modal("show"); 
		$("#adsContainer").hide();
		$("#clock").hide()
		$("#email").hide()
		$("#hamButton").hide()
		$("#spamButton").hide()
		$(".total-earnings").text(Math.max(0,jsLog.credits.totalCredits))
		$(".total-cents").text(totalCents)		
		$("#amountPaid").text(0);
		for (var i=1;i<=N_PHASES; i++){
			$(".credits-phase-"+i).text(jsLog.credits.given[i-1])
		}
		
		log()	
		clearInterval(timer);

		$.ajax({
			type:'post',
  			url: LOGGER,
  			data: {data:JSON.stringify(jsLog)},
  			success:function(data){}
		});

		var externalUrl = turkSubmitTo + "/mturk/externalSubmit";
		var paymentData = "assignmentId=" + assignmentId + "&totalCents="+ totalCents;

		$.ajax({
			type:'post',
  			url: externalUrl,
  			data: paymentData,
  			success:function(data){}
		});


			
	}

	function log(){
		$.ajax({
			type:'post',
  			url: LOGGER,
  			data: {data:JSON.stringify(jsLog)},
  			success:function(data){}
		});

	}

	function log_user_info(){
		var plug_names=[]
		var plugins = navigator.plugins
		for (var i=0; i<plugins.length;i++){plug_names.push(plugins[i].name)}
		jsLog.userIp = USER_IP;
		jsLog.assignemntId = assignmentId;
		jsLog.hitId = hitId;
		jsLog.workerId = workerId;
		jsLog.params = {};
		jsLog.progress = "setup";
		jsLog.n_phases = PHASES;
		jsLog.email_order = EMAIL_ORDER;
		jsLog.credits_per_task = CREDITS_PER_TASK
		jsLog.browserInfo={};
		jsLog.browserInfo.cookiesEnabled = navigator.cookieEnabled;
		jsLog.browserInfo.plugins = plug_names
		jsLog.browserInfo.appName = navigator.appName;
		jsLog.browserInfo.appCodeName = navigator.appCodeName;
		jsLog.browserInfo.browserName = navigator.product;
		jsLog.browserInfo.browserVersion = navigator.appVersion;
		jsLog.browserInfo.userAgent = navigator.userAgent;
		jsLog.browserInfo.platform = navigator.platform;
		jsLog.browserInfo.language = navigator.language;
		jsLog.browserInfo.javaEnabled = navigator.javaEnabled();
		jsLog.browserInfo.windowHeight = $(window).height();
		jsLog.browserInfo.windowWidth = $(window).width();
		jsLog.stages = {}
		jsLog.connection={}
		jsLog.geo = {}
		$.ajax({
			url : "https://freegeoip.net/json/"+USER_IP,
			dataType: "json",
			success : function(data){
				jsLog.geo = data
			}
		})

		jsLog.screenInfo={}
		jsLog.screenInfo.availHeight = screen.availHeight
		jsLog.screenInfo.availWidth = screen.availWidth
		jsLog.screenInfo.colorDepth = screen.colorDepth
		jsLog.screenInfo.height = screen.height
		jsLog.screenInfo.width = screen.width
		jsLog.screenInfo.pixelDepth = screen.pixelDepth

		jsLog.credits = {}
		jsLog.credits.real = [0,0,0,0]
		jsLog.credits.given = [0,0,0,0]
		jsLog.credits.timer = [0,0,0,0]
		jsLog.credits.no_timer = [0,0,0,0]
		jsLog.credits.correct = [0,0,0,0]
		jsLog.credits.totalCorrect = 0
		jsLog.credits.totalCredits = 0


		log();
		

		
	}

	function log_demographics(){

		jsLog.dem = {};
		jsLog.dem.age = $("#inputAge").val();
		jsLog.dem.country = $("#inputResidence").val();
		jsLog.dem.gender = $("#inputGender").val();
		jsLog.dem.income = $("#inputIncome").val();
		jsLog.dem.education = $("#inputEducation").val();
		jsLog.mtId = $("#inputAmazonId").val();
		jsLog.progress='demographics';
		log();
	}
	
	function validate_dem(){
		var age = $("#inputAge").val();
		var country =  $("#inputResidence").val();
		var gender =  $("#inputGender").val();
		var income =   $("#inputIncome").val();
		var education =  $("#inputEducation").val();
		var mtId = $("#inputAmazonId").val();
		var validate = true;

		if (age!=="" && country!=="default" && gender!=="default" && income!=='default' && education!=="" && mtId!=="" ){
			if (age<13 || age>99){
				validate = false;
			}
			if (education<0 || education>30){
				validate = false;
			}
		} else{
			validate = false;
		}

		return validate;
		
	}



	function setupPBDM(){
		$("#spamButton").hide();
		$("#hamButton").hide();
		$("#clock").hide();
		$("#submitBdmBid").show();
		$("#form-bdm").show();
		$("#email").hide();
		$("#adsContainer").hide();

	}

	function setupBDMtut(){
		$("#spamButton").hide();
		$("#hamButton").hide();
		$("#clock").hide();
		$("#submitBdmBid-tut").show();
		$("#form-bdm-tut").show();
		$("#email").hide();
		$("#adsContainer").hide();

	}

	function setupEmail(){
		$("#spamButton").show();
		$("#hamButton").show();
		$("#submitBdmBid").hide();
		$("#form-bdm").hide();
		$("#email").show();



	}
	
	function runPBDM(){	
			
		if (assignment){
			alertOffer("#pbdmWon",function(){
				with_timer=false
				nextEmail()})
			
				
		} else {
			alertOffer("#pbdmLost",function(){
				with_timer=true
				nextEmail()})
								
		}
	

				
	}

	function runBDMtut(){


		$(".tut-credits").text(CREDITS_PER_TASK-offer);
		$(".bdm-credits").text(CREDITS_PER_TASK);
			
			
		if (assignment){
			updateScores(CREDITS_PER_TASK-offer)
			$("#form-bdm-tut").hide();
       		$("#submitBdmBid-tut").hide();				
			alertOffer("#bdmTutorialWon",stageControler)
		} else {
			updateScores(0)			
			$("#form-bdm-tut").hide();
       		$("#submitBdmBid-tut").hide();
			alertOffer("#bdmTutorialLost",stageControler)
		}
		stage++

		
	}


	function alertOffer(modalResult,continueFunction){
		$(".continueButton").unbind()
		$(".continueButton").click(continueFunction);
		$(".bdmOffer").text(offer);
		$(".bdmBid").text(max_credits);
		$(modalResult).modal({backdrop: 'static', keyboard: false});
		$(modalResult).modal("show");
		
	}

	function alertClassify(emailType,guess){
		$("#classificationResult").modal({backdrop: 'static', keyboard: false});
		$("#classificationResult").modal("show");
		$("#credits-earned").text((emailType==guess ? CREDITS_PER_TASK : (-CREDITS_PER_TASK)))	;
		$("#emailType").text(emailType);
		$("#guess").text(guess);
		$("#result").text((emailType==guess ? "Correct" : "Incorrect"))		
	}



	function nextEmail() {

		setupEmail()

		stage++;
		
		jsLog.progress = "Stage:" + stage;
		jsLog.stages['stage'+stage] = {};
		jsLog.stages['stage'+stage].offer = offer;
		jsLog.stages['stage'+stage].max_credits = max_credits;
		jsLog.stages['stage'+stage].assignment = assignment;
		jsLog.stages['stage'+stage].intime =true;
		jsLog.stages['stage'+stage].timer = with_timer;
		jsLog.stages['stage'+stage].ads = ads;
		jsLog.stages['stage'+stage].timeStart = Date.now();		
		log()


		if (ads){
			$.get(GET_AD,function(data){
				$("#ad").attr("src",data.ad_path)
			},"json");
				
			$("#adsContainer").show();
		} else {
			$("#adsContainer").hide();
		}


		if (with_timer){
			var total_time = COUNTDOWN;
			$("#seconds").text(total_time);
			$("#clock").show()
			timer = setInterval(function(){
				total_time--;
				if (total_time>=0){
					$("#seconds").text(total_time);
				} else {
					alert("Time is up. You have lost "+ CREDITS_PER_TASK +" credits.");
					total_time=COUNTDOWN;
					$("#seconds").text("");
					$("#clock").hide()
					clearInterval(timer);
					jsLog.stages['stage'+stage].timeEnd = Date.now();	
					jsLog.stages['stage'+stage].intime =false;
					jsLog.stages['stage'+stage].correct = false;
					updateScores(-CREDITS_PER_TASK)
					log();
					stageControler();

				}
			},1000);
		} else {
			clearInterval(timer);
			$("#clock").hide()
		}		
		email_list = EMAIL_ORDER["phase"+currentPhase]
		email = email_list[stageRel]
		emailType = email[1]
		
		$.ajax({
            	url : "./emails/"+emailType+"/phase"+currentPhase+"/email"+email[0]+".html",
            	dataType: "text",
            	success : function (data) {
                	$("#email-pre").html(data);
            	}
				})

		jsLog.stages['stage'+stage].emailType = email[1];
		jsLog.stages['stage'+stage].emailName = email[0];
		
		log();


		$("#email-pre").show();
		$("#form-bdm").hide();


		
		
		
	}

	function updateScores(credits){
		var tC = 0
		jsLog.credits.real[currentPhase-1] += credits 
		if (currentPhase<N_PHASES){
			jsLog.credits.given[currentPhase-1] =  Math.max(jsLog.credits.real[currentPhase-1],0)
		} else { 
			jsLog.credits.given[currentPhase-1] += credits
		}

		for (var i=0; i<N_PHASES;i++){
			tC += jsLog.credits.given[i]
		}
		jsLog.credits.totalCredits = tC

		if (currentPhase!=3){
			if (with_timer){
				jsLog.credits.timer[currentPhase-1] +=credits
			} else {
				jsLog.credits.no_timer[currentPhase-1] +=credits
			}

			
		}
		log()
		$("#totalCredits").text(tC);
		$("#phase-credits").text(jsLog.credits.real[currentPhase-1]);
		


	}

	function evaluateSpam(){
		clearInterval(timer);
		jsLog.stages['stage'+stage].timeEnd = Date.now();
		jsLog.stages['stage'+stage].answer = "spam";
		window.scrollTo(0, 0);
		var correct = emailType=="spam"
		credits = (correct ? CREDITS_PER_TASK : -CREDITS_PER_TASK)
		type = (correct ? "Spam": "Not Spam")
		updateScores(credits)		
		jsLog.stages['stage'+stage].correct = correct;
		jsLog.credits.correct[currentPhase-1] += (correct ? 1:0)
		jsLog.credits.totalCorrect += (correct ? 1:0)
		log()			
		alertClassify(type,"Spam")

	}
	function evaluateHam(){
		clearInterval(timer);
		jsLog.stages['stage'+stage].timeEnd = Date.now();
		jsLog.stages['stage'+stage].answer = "ham";
		window.scrollTo(0, 0);
		var correct = emailType=="ham"
		credits = (correct ? CREDITS_PER_TASK : -CREDITS_PER_TASK)
		type = (correct ? "Not Spam": "Spam")
		updateScores(credits)	
		jsLog.stages['stage'+stage].correct = correct;
		jsLog.credits.correct[currentPhase-1] += (correct ? 1:0)
		jsLog.credits.totalCorrect += (correct ? 1:0)
		log()				
		alertClassify(type,"Not Spam")

	}
	
	

	function MeasureConnectionSpeed() {
    	var startTime, endTime;
    	var download = new Image();
    	download.onload = function () {
        	endTime = (new Date()).getTime();
        	showResults();
    	}
    
    	startTime = (new Date()).getTime();
    	var cacheBuster = "?nnn=" + startTime;
    	download.src = imageAddr + cacheBuster;
    
   		function showResults() {
        	var duration = (endTime - startTime) / 1000;
        	var bitsLoaded = downloadSize * 8;
        	var speedBps = (bitsLoaded / duration).toFixed(2);
        	var speedKbps = (speedBps / 1024).toFixed(2);
        	var speedMbps = (speedKbps / 1024).toFixed(2);
			jsLog.connection.speedBps = speedBps
			log()
			
    	}
	}
    /**
     * Submits the amazon id (if it is valid) to the database to get a key.
     */
    function submitAmazonId() {
        var amazonId = $("#amazonId").val().trim();
        if (amazonId.length == 0 || amazonId.indexOf("@") != -1) {
            alert("Please enter your amazon ID (not your email).");
            return;
        }

        $("#submitFinal").attr("disabled", "disabled");
        var data = {
            "amazonId" : amazonId,
            "user" : USER_IP,
            "batch" : BATCH,
            "points" : remainingPoints
        };

        $.post(SUBMIT_HIT, data).done(displayKey).fail(function(data) {
            alert("Unknown error, please try submitting again.");
            $("#submi	tFinal").removeAttr("disabled");
        });
    }

    /**
     * Displays a key for the user.
     *
     * @param  {String} data The HTML of the key for the user to enter on MTurk
     */
    function displayKey(data) {
        $("#surveyKey").text(data);
        $("#surveyKeyText").show();
        $("#surveyKey").show();
    }

	function shuffle(array) {
 		var currentIndex = array.length, temporaryValue, randomIndex;

 		 // While there remain elements to shuffle...
 		 while (0 !== currentIndex) {

    		// Pick a remaining element...
    		randomIndex = Math.floor(Math.random() * currentIndex);
    		currentIndex -= 1;

   			 // And swap it with the current element.
    		temporaryValue = array[currentIndex];
    		array[currentIndex] = array[randomIndex];
   			array[randomIndex] = temporaryValue;
  		}

  		return array;
	}
});


	function getUrlParameter(sParam) {
    	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        	sURLVariables = sPageURL.split('&'),
        	sParameterName,
        	i;

    	for (i = 0; i < sURLVariables.length; i++) {
        	sParameterName = sURLVariables[i].split('=');

        	if (sParameterName[0] === sParam) {
            	return sParameterName[1] === undefined ? true : sParameterName[1];
        	}
    }
	};
