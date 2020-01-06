<h4>{{__("ClientSide.share")}}</h4>
<div class="top-social-icons-wrapper pb-4">
    @if($event->social_show_facebook)
    <a class="top-social-icons" href="https://www.facebook.com/sharer/sharer.php?u={{$event->event_url}}" style="margin: 0 3px">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
            <path id="Shape" d="M25,50A25,25,0,0,1,7.322,7.322,25,25,0,1,1,42.677,42.677,24.837,24.837,0,0,1,25,50ZM19.292,21.382v3.869h2.371V36.92H25.5V25.251H29.35l.608-3.869H25.5V19.444c0-1.327.582-1.972,1.779-1.972h2.893V13.612h-4.11a3.916,3.916,0,0,0-3.495,1.531,6.8,6.8,0,0,0-.9,3.9v2.341Z" fill="#d43d34"/>
        </svg>
    </a>
    @endif
    @if($event->social_show_twitter)
    <a class="top-social-icons" href="http://twitter.com/intent/tweet?text=Check out: {{$event->event_url}} {{{Str::words(strip_tags($event->description), 20)}}}" style="margin: 0 3px">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
            <path id="Shape" d="M25,50A25,25,0,0,1,7.322,7.322,25,25,0,1,1,42.677,42.678,24.838,24.838,0,0,1,25,50ZM13.779,33.624a.119.119,0,0,0-.064.219A13.91,13.91,0,0,0,35.128,22.124c0-.164,0-.34-.011-.568a9.922,9.922,0,0,0,2.4-2.5.119.119,0,0,0-.008-.142.121.121,0,0,0-.091-.043.118.118,0,0,0-.048.01,9.605,9.605,0,0,1-2.238.678A4.945,4.945,0,0,0,36.875,17.1a.122.122,0,0,0-.04-.128.119.119,0,0,0-.074-.026.121.121,0,0,0-.061.017,9.553,9.553,0,0,1-2.979,1.149A4.974,4.974,0,0,0,25.27,22.54a13.712,13.712,0,0,1-9.754-5.014.114.114,0,0,0-.088-.044h-.013a.123.123,0,0,0-.093.057,4.973,4.973,0,0,0,1.2,6.384,4.705,4.705,0,0,1-1.735-.56.112.112,0,0,0-.056-.015.116.116,0,0,0-.059.016.12.12,0,0,0-.06.1v.063A5.009,5.009,0,0,0,18.1,28.274a4.7,4.7,0,0,1-.754.061,4.855,4.855,0,0,1-.9-.084l-.023,0a.117.117,0,0,0-.112.154,4.953,4.953,0,0,0,4.311,3.434,9.564,9.564,0,0,1-5.691,1.856,9.691,9.691,0,0,1-1.143-.068h-.013Z" fill="#d43d34"/>
        </svg>
    </a>
    @endif
    @if($event->social_show_linkedin)
    <a class="top-social-icons" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{$event->event_url}}?title={{urlencode($event->title)}}&amp;summary={{{Str::words(strip_tags($event->description), 20)}}}" style="margin: 0 3px">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
            <g id="Social_media" data-name="Social media" transform="translate(-210)">
                <path id="Shape" d="M25,50A25,25,0,0,1,7.323,7.322,25,25,0,1,1,42.677,42.678,24.84,24.84,0,0,1,25,50Zm5.1-26.026c2.361,0,2.361,2.239,2.361,3.873v7.106H37V26.938c0-3.615-.66-6.96-5.447-6.96a4.8,4.8,0,0,0-4.3,2.361h-.06v-2H22.836V34.953h4.537V27.725C27.373,25.87,27.7,23.974,30.1,23.974Zm-14.65-3.632V34.953h4.541V20.342Zm2.271-7.264a2.633,2.633,0,1,0,2.632,2.633A2.636,2.636,0,0,0,17.718,13.078Z" transform="translate(210 0)" fill="#d43d34"/>
            </g>
        </svg>
    </a>
    @endif

</div>
