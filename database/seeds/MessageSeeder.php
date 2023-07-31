<?php

use Illuminate\Database\Seeder;
use App\Message;
class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::create([
        	'subject' => 'Inquiry Added',
        	'message' => 'Dear [FirstName] [LastName], Thank you for visiting PHYSIOFIT. We hope to see you Soon and become part of PHYSIOFIT family.',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'New Memberhsip',
        	'message' => 'Hello [FirstName] [LastName],
							A big warm welcome to our PHYSIOFIT family. Lets get started on a healthy life and a new fit you. Be fit, Be awesome.
							PHYSIOFIT',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Birthday Grettings',
        	'message' => 'Dear [FirstName] [LastName], Many Many happy returns of the day. Fitness 5 wishes that you have best day ever!! May god give all your want. Be fit & Be Fabulous!! ',
        	'type' => 1,
        ]); 

        Message::create([
        	'subject' => 'Anniversary Greetings',
        	'message' => 'Dear [FirstName] [LastName], PHYSIOFIT family wishes you Happy Anniversary! Wish you have a 			great year ahead.',
        	'type' => 2,
        ]);

        Message::create([
        	'subject' => 'Renewal Membership',
        	'message' => 'Hello [FirstName] [LastName],
						WELCOME BACK! We are happy to have you back in our PHYSIOFIT family. Lets get started where we left off, shall we?
						Be fit, Be Awesome.',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Cancel Membership',
        	'message' => 'Hello [FirstName] [LastName]
							We are sad to see you leave. Hope to see you, till then dont forget we are here if you need anything :)',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Transfer Membership',
        	'message' => 'Hello [FirstName] [LastName],
							Your membership with UID [UID] has been transfered to Mr/Mrs. [NewMemberName] with your concern. We are sad to see you leave, call us anytime if you need.',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Freeze Memebership',
        	'message' => 'Hello [FirstName] [LastName],
						As per your request your membership with UID [UID] has been frozen for [Days] days, from [From] to [To]. If this was not done by you, kindly let us know at front office.',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Absent Member',
        	'message' => 'Hello [FirstName] [LastName], Our Records show that you havent been working out regularly, May we know why? A Gentle reminder to start a healthy life now.!! Stay fit. ',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Membership Reminder',
        	'message' => 'Dear [FirstName] [LastName],
						Your membership is about to expire!
						Kindly renew it soon as possible to avoid any inconvience.Visit us at the Reception we would do the needful.',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'PT Mebership New',
        	'message' => 'Dear [FirstName] [LastName],
						Welcome to our Personal Training packages level [EmployeeLevel], we assure you, you are in great hands with our trainer [EmployeeName].',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'PT Membership Renewal',
        	'message' => 'Dear [FirstName] [LastName],
						We are happy to see you back for Personal Training sessions. Good job, lets get one step closer to your fitness goal. Stay Fit!!!',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Assign Package',
        	'message' => 'Dear, [Name of Member],Your Member Id  [ID] Your Packge [Name of Packge] at PHYSIOFIT is Now Active.Transaction Type: [Fully/Partially] Paid. Paid Amount: 100 INR, Start Date:[join date]  End Date:[End Date] Invoice ID [InvoiceID].',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Payment taken',
        	'message' => 'Dear [Name of Member],Member Id [ID]
				We Have Received Payment [Full/Partial] of [Amount] INR Agaist invoice Id [InvoiceID] dated: [Date].
				PHYSIOFIT',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Followup Added',
        	'message' => 'Dear [FirstName] [LastName], Greetings From PHYSIOFIT . We are Trying to Connect you regarding your inquiry for [Packge] Packge on [Date]. For More Information you can Contact [POC] on +91xxxxxxxxxx',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'Registration Added',
        	'message' => 'Dear [FirstName] [LastName], Thank you for Registr...',
        	'type' => 3,
        ]);

        Message::create([
        	'subject' => 'OTP',
        	'message' => 'Dear [FirstName] [LastName],Your Physiofit OTP is [otp].',
        	'type' => 1,
        ]);

    }
}
