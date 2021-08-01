@extends('layout')
@section('title', 'List')

@section('layout_content')

    <div class="row">
        <div class="col-lg-4 col-md-12  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        {{$title}}
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?= UserTable::init()->builddetailtable()
                        ->renderentitydata($user)?>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8  stretch-card">
        </div>
        <div class="col-lg-12 col-md-12  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        Rapport De Session en cours
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-justified " id="myTab" role="tablist">
                        @foreach($member_group_tontines as $i => $membergroup)
                        <li class="nav-item text-center">
                            <a class="nav-link @if($i == 0) @endif text-center" id="{{$membergroup->getGroup_tontine()->getName()}}-tab"
                               data-toggle="tab" href="#{{$membergroup->getGroup_tontine()->getName()}}"
                               role="tab" aria-controls="{{$membergroup->getGroup_tontine()->getName()}}" aria-selected="@if($i == 0)true @else false @endif">
                                Session {{$membergroup->getGroup_tontine()->getName()}}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @foreach($member_group_tontines as $i => $membergroup)
                            @php $session = Session::activeSession($membergroup->group_tontine) ;
                            if (!$session)
                                continue;

                            @endphp
                            <div class="tab-pane @if($i == 0)show @endif "
                                 id="{{$membergroup->getGroup_tontine()->getName()}}" role="tabpanel"
                                 aria-labelledby="{{$membergroup->getGroup_tontine()->getName()}}-tab">
                                <h3>
                                    Session {{$membergroup->getGroup_tontine()->getName()}}
                                </h3>
                                <hr>
                                <div class='row'>
                                    @foreach($membergroup->fundMembers($session) as $fund_member)
                                        <div class="input-group mb-3 col-lg-2">
                                            <div class="input-group-prepend">
                                                <b class="input-group-text"
                                                   id="basic-addon1">{{$fund_member->fund->getLabel()}}</b>
                                            </div>
                                            <input type="text" value="{{ $fund_member->getAmount() }}" readonly
                                                   class="form-control" placeholder="Username" aria-label="Username"
                                                   aria-describedby="basic-addon1">
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <div class='row'>
                                    <div class='col-lg-12'>
                                        <h5>
                                            Historique des contributions
                                        </h5>
                                        {!!
                                            SeanceTable::init(new Seance())
                                                ->buildseancetable($membergroup)
                                                // ->buildSumRow()
                                                ->render()
                                        !!}
                                    </div>
                                    <div class='col-lg-12'>
                                        <h5>Historique Beneficiaire semaine</h5>
                                        <hr>
                                        {!!
                                            BeneficiaryTable::init(new Beneficiary())
                                                ->buildmembertable($member, $session, 1)
                                                // ->buildSumRow()
                                                ->render()
                                        !!}
                                    </div>
                                    <div class='col-lg-12'>
                                        <h5>Historique Beneficiaire mois</h5>
                                        <hr>
                                        {!!
                                            BeneficiaryTable::init(new Beneficiary())
                                                ->buildmembertable($member, $session, 2)
                                                // ->buildSumRow()
                                                ->render()
                                        !!}
                                    </div>
                                    <div class='col-lg-12'>
                                        <h5>Historique Beneficiaire aide</h5>
                                        <hr>
                                        {!!
                                            Beneficiary_helpTable::init(new Beneficiary_help())
                                                ->buildmembertable($member, $session)
                                                // ->buildSumRow()
                                                ->render()
                                        !!}
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-lg-4'>
                                        <h5>Historique Autres sorties</h5>
                                        <hr>
                                        {!! TransactionTable::init(new Transaction())
                                                ->buildmembertable($member,$session, 1)
                                                ->buildSumRowDashboard()
                                                ->render() !!}
                                    </div>
                                    <div class='col-lg-4'>
                                        <h5>Historique Autres entrées</h5>
                                        <hr>
                                        {!! TransactionTable::init(new Transaction())
                                                ->buildmembertable($member,$session, 2)
                                                ->buildSumRowDashboard()
                                                ->render() !!}
                                    </div>
                                    <div class='col-lg-4'>
                                        <h5>Historique sanctions</h5>
                                        <hr>
                                        {!! SanctionTable::init(new Sanction())
                                                ->buildmembertable($member,$session)
                                                ->buildSumRow()
                                                ->render() !!}
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        Liste des Prets de la session
                                        <hr>
                                        {!!
                                            LendingTable::init()->buildmembertable($membergroup)->render();
                                        !!}
                                    </div>
                                    <div class='col-lg-6'>
                                        Liste des Remboursement
                                        <hr>
                                        {!!
                                            MemberTable::init(new Refund())->buildrefundtable($membergroup)->render();
                                        !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection