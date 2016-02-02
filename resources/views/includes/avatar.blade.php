@section('page-script')
    <style>
        /**
        * Profile image component
        */
        .profile-header-container{
            margin: 0 auto;
            text-align: center;
        }

        .profile-header-img {
            padding-left: 10px;
        }

        .profile-header-img > img.img-circle {
            width: 120px;
            height: 120px;
            border: 2px solid #51D2B7;
        }

        .profile-header {
            margin-top: 43px;
        }

        /**
        * Ranking component
        */
        .rank-label-container {
            margin-top: -19px;
            /* z-index: 1000; */
            text-align: center;
        }

        .label.label-default.rank-label {
            background-color: rgb(81, 210, 183);
            padding: 5px 10px 5px 10px;
            border-radius: 27px;
        }
    </style>
@stop

<div class="profile-header-container">
    <div class="profile-header-img">
        <img class="img-circle" src="{{ url($user->avatar->url('thumb')) }}" />
        <div class="rank-label-container">
            <span class="label label-default rank-label">{{ $user->points }} points</span>
        </div>
    </div>
</div>