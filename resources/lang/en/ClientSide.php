<?php

return [

    //cinema.blade.php + concert.blade.php + CinemaItem.blade.php + EventItem.blade.php
    // + MusicalItem.blade.php
    'share' => 'Share',
    'buy_ticket' => 'Buy a ticket',
    'views' => 'Views',
    'prices_from' => 'Prices from',
    'starting' => 'In cinema starting from',

    //subCategoryList.blade.php
    'date' => 'Date',

    //FilterMenu.blade.php
    'select' => 'Select date',
    'popular' => 'Popular',
    'new' => 'New',
    'filter' => 'Filter',
    'today' => 'Today',
    'tomorrow' => 'Tomorrow',
    'week' => 'This week',
    'month' => 'This month',

    //HomeCinema.blade.php
    'view' => 'View all',

    //ItemList.blade.php
    'home' => 'Home',
    'for_cinema' => 'Tickets for cinema',
    'composers' => 'Performers',
    'events' => 'Events',
    'concerts' => 'Concerts',
    'alternatives' => 'Alternatives',
    'bards' => 'Bards',
    'jazz' => 'Jazz & Blues',
    'others' => 'Others',
    'movies' => 'Movies',
    'classic' => 'Classical music',
    'music' => 'Musical performance',
    'musical' => 'Musical',
    'ballet' => 'Opera & Ballet',
    'operetta' => 'Operetta',
    'pop' => 'Pop & Estrada',
    'rave' => 'Rave',
    'rock' => 'Rock',
    'romance' => 'Romance',
    'onDate' => '13 September',
    'onTime' => '19:00, Friday',
    'title' => '"Spider Man"',
    'description' => 'Description.',
    'shown' => 'Shown on page',

    //PublicFooter.blade.php
    'want' => 'Do you want to always be up to date with current events?',
    'subscribe' => 'Subscribe',
    'email' => 'Enter you e-mail',
    "email_for" => "Subscribe to the newsletter and receive a personalized selection of your city's events",
    'cabinet' => 'Personal Cabinet',
    'introduction' => 'INTRODUCTION TO BILETTM.COM',
    'questions' => 'QUESTIONS AND ANSWERS',
    'offices' => 'TICKET OFFICES',
    'rassylka' => 'SEND OUT',
    'collective' => 'COLLECTIVE ORDERS',
    'organizers' => 'TO ORGANIZERS',
    'concert_halls' => 'CONCERT HALLS',
    'partners' => 'PARTNERS',
    'logo' => 'LOGO FOR POSTERS AND MEDIA',
    'addEvent' => 'Add an event',
    'ticket_service' => 'Ticketing service',
    'copyright' => 'All rights reserved',

    //PublicHeader.blade.php
    'placeholder' => 'Events, artists, halls',

    //AddEventForm.blade.php
    'send' => 'Send',
    'required' => 'Required field(s)',
    'name' => 'First Name',
    'phone' => 'Phone',
    'venue' => 'Venue',
    'place' => 'Concert hall Turkmenistan',
    'message' => 'Message',
    'text' => 'Send us information of the event you want to organize! We will see the information and contact you as soon as possible',

    //EventsPage.blade.php
    'rep' => 'The whole repertoire',

    //Event schedule
    'event_dates' =>'Dates',
    'event_times' =>'Times',
    //SearchResults.blade.php
    'search' => 'Search',
    'results' => 'Search results',

    //SeatsPage.blade.php
    'seats' => 'Choose seats',
    'available' => 'Available',
    'booked' => 'Booked',
    'reserved' => 'Reserved',
    'selection' => 'Your Selection',
    'selected' => 'You Have Selected',
    'seatsTotal' => 'seats. Total cost',
    'yourSeats' => 'Your Seats',
    'exceeds' => "You have exceeded maximum ticket count: ",

    //Chcekout page
    'checkout' => 'Checkout',
    'no_seats' => 'No seats selected',
    'min_ticket_message' => 'You must select at least :min tickets.',
    'max_ticket_message' => 'The maximum number of tickets you can register is :max',
    'holder_first_name_required' => 'Ticket holder :seat\'s first name is required',
    'holder_last_name_required' => 'Ticket holder :seat\'s last name is required',
    'holder_email_required' => 'Ticket holder :seat\'s email is required',
    'holder_email_invalid' => 'Ticket holder :seat\'s email appears to be invalid',
    'question_required' => "This question is required",
    'enable_javascript' => 'Please enable Javascript in your browser.',
    'payment_error' => 'Sorry, there was an error processing your payment. Please try again.',
    'payment_cancelled' => 'Payment cancelled',
    'no_ordere_id' => 'Order id does not exist',
    'order_error' => 'Whoops! There was a problem processing your order. Please try again.',
    'message_reserved' => 'Some of selected seats are already reserved',
    'message_wait' => 'Just a second',

    //About page
    'about_us' => 'About us',
    'contacts'=> 'Contacts',
    'about_payment' => 'About payment',
    'how_to_buy' => 'How to buy',
    'refund' => 'Refund',
    'cooperation' => 'Cooperation',
    'oferta' => 'Oferta',


    'terms_conditions' => 'Terms and conditions',

    //add event request and subscribe
    'add_event_success_message' => 'Thanks for request. We will contact you as soon as possible',
    'add_event_error_message' => 'There is some problem occured on adding event request',
    'subscribe_success_message' => 'Subscription successfully',
    'subscribe_error_message' => 'Subscription unsuccessful',

    'currency_code' => ' manat.',
    'booking_fee_text' => 'Booking fee per ticket:',
    'checkout_fail_title' => 'Sorry',
    'checkout_fail_text' => '<p>Ваш запрос находится в процессе обработки Банком. Дождитесь смс-уведомление об оплате. Если
в течении 15 минут билеты не пришли на почту, Ваш заказ отклонен. Попробуйте купить снова.</p>
<p>Причины, по которым могла произойти ошибка:</p>
<ul>
<li>Недостаточно средств на счету.</li>
<li>Банк не успевает обработать запрос.</li>
<li>Нестабильное Интернет-соединение.</li>
</ul>

<p>В случае, если оплата прошла успешно, но билеты не пришли на почту, свяжитесь с нами.</p>',
    'checkout_fail_button' => 'Contact us',
    'redirect_payment_message' =>'Redirecting to payment gateway',
];
