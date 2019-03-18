<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="PBDM.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="PBDM.js" type="text/javascript" charset="utf-8"></script>
    <script src="countries.js" type="text/javascript" charset="utf-8"></script>	
    <title>SPAM Detection Study</title>

    <?php
    $NUMBER_OF_IMAGES = 24;
    ?>
</head>

<body>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Welcome to the Email Classification Experiment</h4>
            </div>
            <div class="modal-body">
                This task is part of a project run by a group of researchers at Stanford University to study work experimental design. As part of this task you'll be asked to classify emails from the Enron public email dataset. You'll need to determine if the email shown to is a SPAM email or not. For parts of the task you will be given the chance to work with or without a time limit (10 seconds per email). 
                <!--[TODO below the # of seconds is defined as <span class="n-seconds"></span>-->
                <hr />
				For the largest portion of the task you will be given the opportunity to pay a portion of your previous earnings in order for the tasks not to be timed. You will be subject to a pricing mechanism (called Personalized BDM) which will be explained in more detail later on. There are a total of four phases, with the fourth one occupying the largest portion of the experiment. You can consider the first three phases as a preparation for the fourth:
				<br>
				<ul>
					<li> Phase 1: Email classification without time limits.</li>
					<li> Phase 2: Email classification with time limits.</li>
					<li> Phase 3: Price mechanism demonstration.</li>
					<li> Phase 4: Email classification with price mechanism</li>
				</ul>
				<hr/>
				For Phase 4 you will be able to use the credits accumulated from the previous phases to remove time limits. Each one of the preliminary phases is self-contained, meaning that the worst you can do per phase is earn 0 credits. This is not true for Phase 4, where you can actually lose money you've earned in the previous phases.
				<hr/>
                No identifying information about you will be requested or recorded as part of this study, and all responses are private and confidential. We will ask some non-identifying demographic questions and will record some non-identifying browser characteristics. Aggregate results may be shared with research collaborators and used in publication.
                <hr />
                This survey should take about 10 minutes to complete. You must complete all tasks to be paid. In the end you'll earn 10 cents for the tutorial plus what you accumulate on the rest of the experiment as a bonus. [TODO how much per credit?] The maximum attainable payout is 2 dollars. If you have any questions, please email <a href="mailto:TODOplaceholder@stanford.edu">TODOplaceholder@stanford.edu</a>.
                <!--
				TODO: Make sure the contact info is available beyond this first screen. IRB tends to requite it. Easiest way is to have a permanent link at the bottom of the page "Review instructions" or something like that, that pops this modal back up. Make sense?
                -->
            </div>
            <div class="modal-footer">
                <button type="button" id="firstClose" class="btn btn-default" >I Understand</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="demographics" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Demographic Survey</h4>
			</div>
				
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="demForm">
					<div class="form-group">
						<label class="control-label" for="inputAge">Age</br></label>
						<div class="row">
							<div class="col-xs-11">
								<input type="number" class="form-control" id="inputAge"></input>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputResidence">Country of Residence</br></label>
						<div class="row">
							<div class="col-xs-11">
								<select id="inputResidence" name="country"></select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputGender">Gender</br></label>
						<div class="row">
							<div class="col-xs-11">
								<select id="inputGender">
							 		<option value="default">Select Gender</option>
  									<option value="F">Female</option>
							 		<option value="M">Male</option>
								</select>							
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputIncome">Yearly Income in US dollars</br></label>
							<div class="row">
							<div class="col-xs-11">
								<select id ="inputIncome">
							 		<option value="default">Select Income</option>
  									<option value="1">Less than $10,000</option>
							 		<option value="2">$10,000-$14,999</option>
									<option value="3">$15,000-$24,999</option>
									<option value="4">$25,000-$39,999</option>
									<option value="5">$40,000-$59,999</option>
									<option value="6">$60,000-$74,999</option>
									<option value="7">$75,000-$99,999</option>
									<option value="8">$100,000-$149,999</option>
									<option value="9">$150,000-$199,999</option>
									<option value="10">$200,000-$299,999</option>
									<option value="11">$300,000 or more</option>


								</select>							
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputEducation">Years of Education</br></label>
							<div class="row">
							<div class="col-xs-11">
								<input type="number" class="form-control" id="inputEducation"></input>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputAmazonId">Amazon Worker ID (If this is incorrect you won't get paid)</br></label>
							<div class="row">
							<div class="col-xs-11">
								<input type="text" class="form-control" id="inputAmazonId"></input>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" id="secondClose" class="btn btn-default">Save changes</button>
			</div>
		</div>
	</div>
</div>

<script language="javascript">
	populateCountries("inputResidence");
</script>



<div class="modal fade" id="gameInstructions1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Instructions for Phase 1</h4>
            </div>
            <div class="modal-body">
                <span class="important">Read all instructions carefully, because they will determine how much you'll get paid for the study.</span>
                <hr />
					We'll first run  <span class="n-phase1"></span> email classification rounds without any time constraints. Read the email and then click either the "Spam" or "Not Spam" button at the bottom of the page. 
				<hr />
You will win <span class="credits-per-task"></span> credits for each email you classify correctly, but will lose <span class="credits-per-task"></span> credits if the email is incorrectly classified. At the end of this phase if you end up with negative credits the losses will be pardoned.     
				 <hr />
            </div>
            <div class="modal-footer">
                <button type="button" id="instructions1Button" class="btn btn-default" data-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gameInstructions2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Instructions for Phase 2</h4>
            </div>
            <div class="modal-body">
                <span class="important">Read all instructions carefully, because they will determine how much you'll get paid and how much you will spend on the experiment.</span>
                <hr />
			Now you will complete <span class="n-phase2"></span> email classification rounds <b>with time constraints</b>. Read the email text and then click either the "Spam" or "Not Spam" button at the bottom of the page. You will only have <span class="n-seconds"></span> to classify the email.
			<hr />
			You will win <span class="credits-per-task"></span> credits for each email you classify correctly, but will lose <span class="credits-per-task"></span> credits if the email is incorrectly classified. At the end of this phase if you end up with negative credits the losses will be pardoned.   
			</div>
            <div class="modal-footer">
                <button type="button" id="instructions2Button" class="btn btn-default" data-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gameInstructions3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Instructions for the Price Mechanism</h4>
            </div>
            <div class="modal-body">
                <span class="important">Read all instructions carefully, because they will determine how much you'll get paid and how much you will spend on the experiment.</span>
                <hr />
					Now you'll get familiarized with our pricing mechanism. For the next <span class="n-phase3"></span> rounds of email classification, 
					<!-- [TODO always >1? Otherwise change rounds to round(s)]-->
				 	you will be able to earn  <span id="credits-per-task"></span> credits per round. 
				 	<!-- TODO What about losses here? -->
				 	However you will have to play the following game:
	<br>
	<ol>
		<li>Tell us what is the maximum amount you are willing to pay to participate (call it W)</li>
		<li>We'll draw a price at random (call it P) </li>
		<li>If P is larger than W then you won't participate and won't have to pay anything</li> 
		<li>If P is smaller than W then you will pay P credits and get  <span class="credits-per-task"></span> in return </li> 
	</ol>
				<hr/>
				The best strategy for this mechanism is to sincerely report your willingness to pay: the maximum amount you would be willing to pay to participate.
                <hr />
					Example 1: 
			<ol>
				<li> If you offered 5 credits (W=5)</li>
				<li> We draw a 3 at random (P=3) </li> 
				<li> You would earn <span class="credits-per-task"></span> credits and pay P=3 in return.
			</ol>
					Example 2:

			<ol>
				<li> If you offered 5 credits (W=5)</li>
				<li> We draw a 6 at random (P=3) </li> 
				<li> You would win nothing and pay nothing.</li>
			</ol>
            </div>
            <div class="modal-footer">
                <button type="button" id="instructions3Button" class="btn btn-default" data-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="gameInstructions4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Instruction for Remaining Tasks</h4>
            </div>
            <div class="modal-body">
                <span class="important">Read all instructions carefully, because they will determine how much you'll get paid and how much you will spend on the experiment.</span>
                <hr />
					<b> This is the last time you'll play with the pricing mechanism so be careful of the offer you make</b>. In the next page you will be asked to provide the largest amount you are willing to pay not to have a timer on <b>all of the remaining <span class=n-phase4></span> tasks</b>. This will constitute your final offer. We'll then draw a price at random. If our bid is lower than your offer, you'll get to work without a timer for the remaining <span class=n-phase4></span> tasks and pay only the random price we drew. Otherwise you won't have to pay any of your credits and will have to work with a timer. If you offer more credits than the ones you have they will be substracted from your earnings from the remaining tasks. 
				 <hr />
					The following summary shows the number of credits you earned or lost during the first and second phase. This is, working without and with a timer:
			<ul>
				<li><b>With timer: <span class="correct-timer"></span> credits.</b></li>
				<li><b>Without timer: <span class="correct-no-timer"></span> credits.</b></li>
			</ul>
            </div>
            <div class="modal-footer">
                <button type="button" id="instructions4Button" class="btn btn-default" data-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="pbdmWon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">You won't have a time restriction!!!</h4>
            </div>
            <div class="modal-body">
			<b>The randomly drawn price was : <span class="bdmOffer"></span></b></br>
			<b>	You offered: <span class= "bdmBid"></span>  </b>
                 <hr />
				Since the price was lower than what you offered you get to work without a timer. You'll only have to pay  <span class="bdmOffer"></span></b>
				<hr />
					If you had offered <span id="bdmSmallerOffer"></span></b> credits, you would have had to work with a timer instead of paying  <span class="bdmOffer"></span></b>. Also remember that whatever price you would have selected larger than  <span class="bdmOffer"></span></b> would only have made you pay  <span class="bdmOffer"></span></b> credits.


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default continueButton" data-dismiss="modal" >Continue</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="pbdmLost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">You will have to work with a timer.</h4>
            </div>
            <div class="modal-body">
				<b>The randomly drawn price was: <span class="bdmOffer"></span></b></br>
				<b>	You offered: <span class= "bdmBid"></span>  </b>
                 <hr />
				Since the price was larger than what you offered you will have to work with a timer. 
				<hr />
					If you had offered anything larger than <span class="bdmOffer"></span></b> credits, you would have worked without a timer and payed only <span class="bdmOffer"></span></b>.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default continueButton" data-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="bdmTutorialWon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">YOU WON <span class="tut-credits"></span> CREDITS !!!</h4>
            </div>
            <div class="modal-body">
			<b>The randomly drawn price was: <span class="bdmOffer"></span></b></br>
			<b>	You offered: <span class= "bdmBid"></span>  </b>
                 <hr />
				Since the price was lower than what you offered, you win the  <span class="bdm-credits"></span> credits. You'll only have to pay <span class="bdmOffer"></span> since this was the random draw. So in total you won <span class="bdm-credits"></span> - <span class="bdmOffer"></span> = <span class="tut-credits"></span> credits.
				<hr />
					If you had offered <span class="bdmSmallerOffer"></span> [TODO something is up] credits, you would have not earned the credits. Also remember that whatever price you would have selected larger than  <span class="bdmOffer"></span> would only have made you pay  <span class="bdmOffer"></span> credits.
				<!-- TODO check whole document for </b> tags around <span>s. -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default continueButton" data-dismiss="modal" >Continue</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="bdmTutorialLost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> You did not win any credits. </h4>
            </div>
            <div class="modal-body">
				<b>The randomly drawn price was: <span class="bdmOffer"></span></b></br>
				<b>	You offered: <span class= "bdmBid"></span>  </b>
                 <hr />
				Since the price was larger than what you offered you did not gain anything or had to pay anything. 
				<hr />
					If you had offered anything larger than <span class="bdmOffer"></span></b> credits, you would have payed only <span class="bdmOffer"></span> and earned the <span class="bdm-credits"></span> credits. Earning in total <span class="tut-credits"></span> credits</b>.


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default continueButton" data-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="classificationResult" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">You were <span id=result></span></h4>
            </div>
            <div class="modal-body">
				<b>The email you read was: <span id="emailType"></span></b></br>
				<b>	You said: <span id= "guess"></span>  </b>
                 <hr />
				You earned <span id="credits-earned"></span> credits.
				<!-- TODO "In this phase you have earned a total of X credits." -->
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id = "classifyButton" data-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="finalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Thanks for Participating!!!</h4>
            </div>
            <div class="modal-body">
					Thanks for participating on this study.
                <hr />
					You earned the following amount on each phase:
					<ul>
						<li>Phase 1: <span class="credits-phase-1"></span>  Credits</li>
						<li>Phase 2: <span class="credits-phase-2"></span>  Credits</li>
						<li>Phase 3: <span class="credits-phase-3"></span>  Credits</li>
						<li>Phase 4: <span class="credits-phase-4"></span>  Credits</li>
					</ul>
					In total you earned <span class="total-earnings"></span> credits corresponding to <span class="total-cents"></span> cents.
					<!-- TODO Explain how it'll be a bonus on top of the 10 cents -->
					<!-- TODO Make sure you have some clauses in the payment code to not pay more than e.g. 2$ per user. There might be people
					who figure out how to hack to the submission system to have their browser change the values that get submitted. --> 
				Please copy and paste the following code on Mechanical Turk to complete the HIT.

				 <hr />
					<b><span id="codeAWS"></span></b>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-sm-12">
         <div class="text-center">
          	<h1>Email Classification Experiment</h1>
         </div>
         <div class="text-center">
             <h4>
                 <a id="instructionsButton">Click Here For Instructions</a>
             </h4>
         </div>
	</div>
</div>


<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-sm-12">
		<div class="row">
        <div id="counters" class="text-center"> 
            <div class="summaryText"><h3 id='stageTitle'>Tutorial</h3></div>
			<div class="summaryText"> Total Credits: <span id="totalCredits">0</span></div>
			<div class="summaryText" >Stage: <span id="stageCounter">0</span> / <span id="totalStages"></span> , Phase <span class="current-phase"></span> Credits: <span id="phase-credits">0</span></div>
		</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2"></div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
			<div class="row">
				<form id="form-bdm" role="form">
					<div class="form-group">
						<label class="control-label" id="text-bdm" for="inputPBDM"> Please indicate what is the largest amount of credits you would pay in order not to see any advertisements:</label>
						<div class="row">
							<input type="number" class="form-control" id="inputPBDM" value=0></input>
						</div>
					</div>
				</form>
			</div>
			<div class="row" style="text-align: center;">
					<button type="button" id="submitBdmBid" class="btn btn-default btn-lg navbar-btn">Start</button>
			</div>

	</div>
	
</div>

<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2"></div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
			<div class="row">
				<form id="form-bdm-tut" role="form">
					<div class="form-group">
						<label class="control-label" id="text-bdm-tut" for="inputBDM"> Please indicate what is the largest amount of credits you would pay in order to win 10 credits:</label>
						<div class="row">
							<input type="number" class="form-control" id="inputBDM" value=0></input>
						</div>
					</div>
				</form>
			</div>
			<div class="row" style="text-align: center;">
					<button type="button" id="submitBdmBid-tut" class="btn btn-default btn-lg navbar-btn">Start</button>
			</div>

	</div>
	
</div>

<div class="row">
	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		<div class="affix">
			<div id="clock">Time left:</br> <span id="seconds"></div>
			<div id="adsContainer"><img id="ad"/></div>
		</div>
	</div>
	<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
			<div class="row">
    			<div id="email">
					<pre id="email-pre"></pre>
				</div>
			</div>

			<div class="btn-toolbar" id="right-side" style="text-align: center;">
                <button target="counters" id="spamButton" type="button" class="btn btn-primary btn-lg navbar-btn">Spam</button>
				<button target="counters" type="button" id="hamButton" class="btn btn-primary btn-lg navbar-btn">Not Spam</button>
			</div>
			
	</div>
</div>
	
<div class="row">
	 <div class="col-lg-8 col-lg-offset-2 col-sm-12">
        <div id="questions" class="text-center">
            <div>
                <input class="form-control" id="amazonId" type="text" placeholder="Amazon Worker ID" maxlength="30">
                <button type="button" id="submitFinal" class="btn btn-default navbar-btn">Submit Hit</button>
                <h4 id="surveyKeyText">Copy and paste this key into the Amazon Mechanical Turk "Survey Key" box.</h4>
                <h2 id="surveyKey"></h2>
            </div>


        </div>

        <div class="row">
			<br>
			<br>
            <div class="footer text-center">
                <h4>
                    <!-- TODO Don't forget to update (1) Privacy and (2) Contact us! -->
                    <a href="//www.microsoft.com/privacystatement/en-us/Research/Default.aspx">Privacy</a> | 
                    <a href="mailto:imanol@stanford.edu">Contact Us</a> |  Stanford University
                </h4>
            </div>
        </div>

        <div id="inputVariables" style="visibility: hidden;">
            <div id="ipAddress"><?= $_SERVER['REMOTE_ADDR'] ?></div>
        </div>
    </div>
</div>



</body>
</html>
