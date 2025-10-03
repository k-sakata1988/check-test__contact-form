            @extends('layouts.app')

            @section('css')
            <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
            @endsection

            @section('header')
            <ul class="header-nav">
                @if (Auth::check())
                <li class="header-nav__item">
                    <form class="form" action="/logout" method="post">
                        @csrf
                        <button class="header-nav__button">ログアウト</button>
                    </form>
                </li>
                @endif
            </ul>
            @endsection

            @section('content')
            <div class="admin__content">
                <div class="admin__heading">
                    <h2>Admin</h2>
                </div>

                <form class="search-form">
                    <div class="search-form__item">
                        <div class="search-form__item-input">
                            <input type="text" name="keyword" placeholder="名前またはメールアドレスを入力してください" value="{{ request('keyword') }}">
                            <select class="search-form___item-select"name="gender">
                                <option value="all">性別</option>
                                <option value="1" {{ request('gender')=='1' ? 'selected':'' }}>男性</option>
                                <option value="2" {{ request('gender')=='2' ? 'selected':'' }}>女性</option>
                                <option value="3" {{ request('gender')=='3' ? 'selected':'' }}>その他</option>
                            </select>
                            <select class="search-form__item-select" name="category_id">
                                <option value="">お問い合わせ種類</option>
                                @foreach(App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id ? 'selected':'' }}>
                                        {{ $cat->content }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="search-form__input--text">
                                <input type="date" name="date" value="{{ request('date') }}">
                            </div>
                        </div>
                    </div>
                    <div class="search-form__button">
                        <button class="search-form__button-submit" type="submit">検索</button>
                        <a class="search-form__button-reset" href="/admin">リセット</a>
                        <a class="search-form__button-export" href="{{ route('admin.contacts.export', request()->all()) }}', request()->all()) }}">エクスポート</a>
                    </div>
                    <div class="pagination">
                        {{ $contacts->links() }}
                    </div>
                </form>

                <div class="contact-table">
                    <table class="contact-table__inner">
                        <tr class="contact-table__row">
                            <th class="contact-table__header">
                                <span class="contact-table__header-span">お名前</span>
                                <span class="contact-table__header-span">性別</span>
                                <span class="contact-table__header-span">メールアドレス</span>
                                <span class="contact-table__header-span">お問合せの種類</span>
                                <span class="contact-table__header-span">　　　</span>
                            </th>
                        </tr>
                        @foreach($contacts as $contact)
                        <tr class="contact-table__row">
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                            <td>{{ $contact->gender }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->category->content }}</td>
                            <td>{{ $contact->created_at }}</td>
                            <td class="contact-table__actions">
                                <button class="contact-table__detail show-detail" data-id="{{ $contact->id }}">詳細</button>
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="contact-table__delete" type="submit" onclick="return confirm('削除しますか？')">削除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div id="detailModal" class="modal" style="display:none;">
                <div class="modal__content">
                    <span class="modal__close">×</span>
                    <div id="modal-body" class="modal__body"></div>
                </div>
            </div>

            <script>
            document.querySelectorAll('.show-detail').forEach(btn => {
                btn.addEventListener('click', function(){
                    let id = this.dataset.id;
                    fetch('/admin/contacts/' + id)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('modal-body').innerHTML = `
                                <p>名前: ${data.last_name} ${data.first_name}</p>
                                <p>性別: ${data.gender}</p>
                                <p>メール: ${data.email}</p>
                                <p>住所: ${data.address}</p>
                                <p>建物: ${data.building}</p>
                                <p>種類: ${data.category_id}</p>
                                <p>内容: ${data.detail}</p>
                            `;
                            document.getElementById('detailModal').style.display = 'block';
                        });
                });
            });

            document.querySelector('.modal__close').addEventListener('click', function(){
                document.getElementById('detailModal').style.display = 'none';
            });
            </script>
            @endsection
