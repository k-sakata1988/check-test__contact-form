    @extends('layouts.app')
    @section('css')
    <link rel="stylesheet" href="{{asset('css/confirm.css')}}">
    @endsection
    @section('content')
        <div class="confirm__content">
            <div class="confirm__heading">
            <h2>Confirm</h2>
            </div>
            <form class="form" action="/contacts" method="POST">
                @csrf
                <div class="confirm-table">
                    <table class="confirm-table__inner">
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">お名前
                            </th>
                            <td class="confirm-table__text">
                                <!-- <input type="text" name="name" value="{{$contact['last_name']}}  {{$contact['first_name']}}" readonly /> -->
                                <p>{{ $contact['last_name'] }} {{ $contact['first_name'] }}</p>
                                    <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
                                    <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">性別
                            </th>
                            <td class="confirm-table__text">
                                <p>{{ $contact['gender'] == 1 ? '男性' : ($contact['gender']==2?'女性':'その他') }}</p>
                                <!-- <input type="text" name="gender" value="{{$contact['gender']}}" readonly /> -->
                                <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">メールアドレス
                            </th>
                            <td class="confirm-table__text">
                                <!-- <input type="email" name="email" value="{{$contact['email']}}" readonly /> -->
                                <p>{{$contact['email']}}</p>
                                <input type="hidden" name="email" value="{{ $contact['email'] }}">
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">電話番号
                            </th>
                            <td class="confirm-table__text">
                                <!-- <input type="tel" name="tel" value="{{$contact['tel1']}}{{$contact['tel2']}}{{$contact['tel3']}}" readonly/> -->
                                <p>{{$contact['tel1']}}{{$contact['tel2']}}{{$contact['tel3']}}</p>
                                <input type="hidden" name="tel" value="{{ $contact['tel1'] }}-{{ $contact['tel2'] }}-{{ $contact['tel3'] }}">
                            </td>   
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">住所
                            </th>
                            <td class="confirm-table__text">
                                <!-- <input type="text" name="address" value="{{$contact['address']}}" readonly/> -->
                                <p>{{$contact['address']}}</p>
                                <input type="hidden" name="address" value="{{ $contact['address'] }}">
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">建物名
                            </th>
                            <td class="confirm-table__text">
                                <!-- <input type="text" name="building" value="{{$contact['building']}}" readonly/> -->
                                <p>{{$contact['building']}}</p>
                                <input type="hidden" name="building" value="{{ $contact['building'] }}">
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">お問い合わせの種類
                            </th>
                            <td class="confirm-table__text">
                                <!-- <input type="text" name="category" value="{{$contact['category_id']}}" readonly /> -->
                                <p>{{$contact['category_id']}}</p>
                                <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
                            </td>
                        </tr>
                        <tr class="confirm-table__row">
                            <th class="confirm-table__header">お問い合わせ内容
                            </th>
                            <td class="confirm-table__text">
                                <!-- <input type="text" name="detail" value="{{$contact['detail']}}" readonly /> -->
                                <p>{{$contact['detail']}}</p>
                                <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">送信</button>
                    <a href="/contacts/edit" class="form__button-edit">修正</a>
                </div>
            </form>
        </div>
    @endsection