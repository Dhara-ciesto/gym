<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
</head>
<style>
    body {
        text-align: justify;
        text-justify: inter-word;
        margin-left: 10px;
        margin-right: 10px;
        font-size: 11;
    }

    .text {
        font-size: 10;
    }

    footer {
        position: fixed;
        bottom: -30px;
        left: 0px;
        right: 0px;
        height: 50px;
        /** Extra personal styles **/
        background-color: white;
        color: black;
        text-align: right;
    }

    footer.page:after {
        content: counter(page, upper-roman);
    }

    td {
        border-bottom: 1px solid #ddd;
        border-right: 1px thin gray;
        margin: 5px;
        border-color: gray;
    }

    p {}

    table {}

    .pagenum:before {
        content: counter(page);
    }
</style>

<body>@php $PAGE_NUM = 1; @endphp
    <footer>
        <!--   <div><span class="pagenum"  style="float: left; margin-top: 2px; margin-bottom: 2px;"></span></div>
          <div style="float: right;" ><span >signature</span></div> -->
    </footer>
    <div style="float: right">
        <img style="width: 120px; height: 120px;  margin-left: -40px; margin-right: 8px;" src="images/fitness5.png">
    </div>
    <div>
        <div style="float: left; margin-top: -20px;  font-size: 11;">
            <p><b>Fitness 5</b><br>
				 GSTIN:  24BDLPG2978J1Z7 <br/>
				"Kruna Nidhan" <br/>
				Kotecha Chowk, <br/>
				Rajkot 360005. <br/>
				Email:info@fitness5.in <br/>
				Mo. : 0281 2583005/2587005 </font> </p>
        </div>
    </div>
    <br>
    <br>
    <div class="content" style="margin-top: 80px;">
        <h3 style="margin-left: 200px;">Consent Form of {{  ucfirst($request->firstname)}} {{  ucfirst($request->lastname)}} #{{$request->memberid}}</h3>
        <p style="font-size:10">Member Name: @if($request->firstname)<b>
        {{  ucfirst($request->firstname)}}  {{  ucfirst($request->lastname)}}</b>@else _____________________ @endif
            <br>Cell No.: @if( $request->phone)<b>
        {{  $request->phone}}</b>@else _____________________ @endif
            <br>Email @if( $request->email)<b>
         {{$request->email}}</b>@else _____________________ @endif
            <br>
            <h4>In consideration of my desire to engage in an exercise programme at the FITNESS5. I Understand and Agree to following:</h4>
            <center><b style="margin-top: -400px !important; padding-top:-200px;">TERMS & CONDITIONS</b>
            </center>
    </div>
    <div class="text">
        <ul style="circle" style="justify-content:center; ">
            <li style="circle">Fitness5 reserves the rights of admission.</li>
            <li style="circle">Only member of 16 years of age and above are allowed in the gymnasium, unless specified otherwise, with parental permission and under supervision of Management.</li>
            <li style="circle">Fee for various types of memberships shall be indicated in the schedule of fees and may change at anytime without prior notice. Membership fee for the entire membership period has to be paid in advance with Membership application and is non refundable.</li>
            <li style="circle">Management cannot be held accountable for any loss or theft of any personal belongings from Locker room or any part of the premises.</li>
            <li style="circle">Each Member needs to empty the locker and remove the padlock when leaving the facility. Fitness 5 Gym will open and empty lockers if the Member is not in the facility.
                <li style="circle">The facility shall be used for training purposes only. No other activity will be allowed or violations will be sanctioned. For example, sleeping and lingering are not allowed. Any kind of steriods are prohibited on Fitness5 premises. Any member caught in this crime will be banned & his/her membership will be terminated immediately.</li>
                <li style="circle">Smoking, consumption of alcoholic drinks, chewing tobacco/Pan, use of drugs of any kind and gambling is strictly prohibited on Fitness 5 premises.</li>
                <li style="circle">Members can enter the gymnasium and use the facility at their own risk. Our facility includes the usage of specialised equipment and members are deemed to have up to date knowledge of the use of such equipment.</li>
                <li style="circle">Management reserves the right to terminate the membership without assigning any reason whatsoever. Termination of membership by the member of management will not entitle the member to any refund of fees or part thereof.</li>
            </li>
            </br>
            <br>
            <br>The Member shall respect the behavioral and operating principles and follow them on all occasions. This includes, but is not limited to:</li>
            <ol style="margin-left: 20px;">
                <li>Wearing appropriate workout attire like T-shirts, shorts or tracksuits & training shoes during your workout.</li>
                <li>Outside shoes strictly not allowed inside gym premises. Please bring extra shoes with you to do your workout.</li>
                <li>Using a towel is compulsory and members are required to leave machines and surfaces clean after usage.</li>
                <li>Behaving in a friendly and respectful manner towards the other members in the gym as well as the staff.</li>
                <li>Consumption of outside food is prohibited in the gym premises.</ol>
            </li>
        </ul>
        <p>
            <br>I , <b>{{  ucfirst($request->firstname)}}   {{  ucfirst($request->lastname)}} </b> hereby agree to all the membership terms and conditions mentioned above &nbsp; and further more detailed rules and regulations on the website:www.fitness5.in
            <center><b>WAIVER</b>
            </center>
            <!-- <ol style="line-height:10px;"> -->
            <ol>
                <li>PURPOSE & EXPLANATION PROCEDURE
                    <ul style="circle" style="justify-content:center; line-height:10px;">
                        <li>This program may or may not benefit my physical fitness or general health. My involvement in the exercise will allow me to properly perform conditioning exercise, use fitness equipment, and regulate physical effort.</li>
                        <li>I may undergo exercise tests for fitness assessment prior to the start of fitness participation in order to evaluate my present level of fitness, develop program & monitor my progress.</li>
                        <li>Fitness training is an activity that involves physical contact to ensure proper technique and body alignment is maintined during the training.</li>
                    </ul>
                    <br>
                    <li>RISKS
                        <ul style="circle" style="justify-content:center; line-height:10px;">
                            <li>There is possibility of adverse changes occurring during exercise including, but not limited to: abnormal blood pressure, fainting, dizziness, and very rare instance of heart attack, stroke or even death.</li>
                            <li>There exists the risk of severe injury, including but not limited to, injuries to the muscles, ligaments, tendons and joint of the body. .</li>
                        </ul>
                        <br>
                        <li>ACCESS & SECURITY
                            <br>
                            <ul style="" style="justify-content:center; line-height:10px;">
                                <li>I understand and agree to camera surveillance in the Fitness 5 Gym facilities, where the data will be stored for 7 days, then deleted. I agree for aregistered 3D fingerprint. The 3D fingerprint identification is done without possibility of personal identification or fingerprint reproduction. I guarantee to never let in any other member, nor another person into the Fitness 5 Gym premises.</li>
                            </ul>
                            <br>
                            <li>CONFIDENTALITY & USE OF INFORMATION
                                <ul style="" style="justify-content:center; line-height:10px;">
                                    <li>I understand that information obtained about me in this fitness program will be a privilege and kept confidential and consequently not be realised or revealed to any person without my consent. Any other information obtained, however, will be used only by the program staff in the course of prescribing exercise for me and evaluating my progress in the program.</li>
                                </ul>
                                <br>
                                <li>TRADINESS & CANCELLATION&FROZEN MEMBERSHIP
                                    <br>I understand and agree that:
                                    <ul style="circle" style="justify-content:center; ">
                                        <li>All memberships are non-­refundable.</li>
                                        <li>All clients and trainers are encouraged to be prompt. If a client arrives late, this time will be deducted from the class. Similarly, if trainer arrives late, the amount of time will be added (I understand that I will be charged for any unused classes that I miss, if the trainers does not contact me at least 24 hours in advance to cancel or reschedules the class. I will receive a complimentary class.)</li>
                                        <li>Residual days of my membership plan can be transferred for a nominal fee of Rs.3999/-­ Plus taxes to a non-­‐member who is not an ex-­member of Fitness5.</li>
                                        <li>I can freeze my membership plan for a nominal fee of Rs. 999/-­ plus taxes for i) medical reasons, upon presentation of a medical certificate, or ii) military service, upon presentation of the official call to duty. The membership can be put on hold for minimum 15 days to maximum 30 days, after which the membership is automatically reactivated, available only in a 6 month or 12 month membership plan. The membership cannot be frozen in retrospect.</li>
                                    </ul>
                                    <br>
                                    <li>INSURANCE
                                        <ul style="" style="justify-content:center; line-height:10px;">
                                            <li>I confirm that I hold the necessary insurances to cover any training incident. I understand that Fitness 5 Gym shall not be subject to any claim, demand, or injury whatsoever.</li>
                                        </ul>
                                        <br>
                                        <li>LIABILITY
                                            <ul style="" style="justify-content:center; line-height:10px;">
                                                <li>I understand that I shall be liable for any Fitness 5 Gym property damage and/or personal injury caused by me at the Fitness 5 Gym premises. It shall be my obligation to pay for any costs involved upon presentation of a statement thereof.</li>
                                            </ul>
            </ol>
            <p>I/We hereby release fitness5,its partners, affliates, officers, directores, agents employee and the owner of club from all claim actions, cost, losses and expenses and/or damage including attorney fees that i/we might have for any inquiries or damage resulting from my use of the equipment or facilities of fitness5.Such Release is to be binding upon my heir, successors and assignees. I/We have full knowledge of proper use of the facilities of Fitness5 as well as to my/our physical limitations and i/we have aggreed to identify the management of Fitness5 against all the claims whatsoever.</p>
            <p>I HAVE READ THE ABOVE WARNING, WAIVER, RELEASE, AND ASSUMPTION OF RISK. I FULLY UNDERSTAND ITS CONTENTS, AND THAT I HAVE GIVEN UP SUBSTANTIAL RIGHTS BY SIGNING IT. I HEREBY SIGN IT VOLUNTARILY WITHOUT ANY INDUCEMENT, ASSURANCE, OR GUARANTEE BEING MADE TO ME AND INTEND MY SIGNATURE TO BE A COMPLETE AND UNCONDITIONAL RELEASE OF ALL LIABILITY.</p>
    </div>
    </div>
    <div>
        <table width="100%" style="margin-left: 8px;   margin-right: 40px; border-width: 2px;border-color: black;">
            <tr>
                <td style="border:2px;"></td>
                <td style="border:2px;"></td>
                <td style="border:2px;"></td>
            </tr>
            <tr>
                <td style="border:1px solid; border-color: gray; height: 25px;color: lightgray;text-align:center;">Signature</td>
                <td style="border:1px solid;border-color: gray;height: 25px;color: lightgray;text-align:center;">Signature</td>
                <td style="border:1px solid;border-color: gray;height: 25px;color: lightgray;text-align:center;">Signature</td>
            </tr>
            <tr>
                <td style="border:none; text-align: center;">(MEMBER)</td>
                <td style="border:none; text-align: center;">(WITNESS)</td>
                <td style="border:none; text-align: center;">TEAM FITNESS5</td>
            </tr>
        </table>
    </div>
    </div>
    </section>
    </div>
</body>

</html>
