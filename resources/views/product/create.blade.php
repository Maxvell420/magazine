<x-layout :styles="$styles" :title="$title">
    <x-adminHeader/>
    <div class="wrapper">
        <div class="form">
            <h3>Создание продукта</h3>
            <form action="{{route('product.save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="name">Название продукта:</label>
                <input type="text" name="name" id="name" value="{{old('name')}}">
                <label for="subcategoryInput1">Подкатегория продукта:</label>
                <input type="text" name="subcategory" id="subcategoryInput1" value="{{old('subcategory')}}">
                <ul id="subcategoryList1" class="dropdown"></ul>
                <label for="price">Цена:</label>
                <input type="number" id="price" name="price" min="1" value="{{old('price')}}">
                <label for="quantity">Количество:</label>
                <input type="number" id="quantity" name="quantity" value="{{old('quantity')}}">
                <label for="file">Фотографии товара:</label>
                <input type="file" id="file" name="images[]" value="{{old('images[]')}}">
                <button type="button" id="more">Добавить еще свойство</button>
                <button type="submit" id="save">Сохранить</button>
            </form>
        </div>
        <div class="form">
            <h3>Создание категории продуктов</h3>
            <form action="{{route('category.save')}}" method="post">
                @csrf
                <label for="name">Название категории</label>
                <input type="text" name="name" id="name">
                <button type="submit" id="save">Сохранить</button>
            </form>
        </div>
        <div class="form">
            <h3>Создание подкатегории продуктов</h3>
            <form action="{{ route('subcategory.save') }}" method="post">
                @csrf
                <label for="categoryInput2">Категория товара:</label>
                <input type="text" id="categoryInput2" name="category" placeholder="Категория">
                <ul id="categoryList2" class="dropdown"></ul>
                <label for="name">Название подкатегории</label>
                <input type="text" name="name" id="name">
                <button type="submit" id="save">Сохранить</button>
            </form>
        </div>
    </div>
</x-layout>

<script>
    let number = 0;
    let moreButton = document.getElementById('more');

    let categoryInput2 = document.getElementById('categoryInput2')
    categoryInput2.addEventListener('input',function (){
        let ul = document.getElementById('categoryList2')
        ul.innerHTML=''
        if(this.value){
            let filtered = {!! $categoryNames !!}.filter(function (name){
                return name['name'].startsWith(categoryInput2.value)
            })
            for (let filteredElement of filtered) {
                let li = document.createElement('li')
                li.textContent = filteredElement['name']
                li.addEventListener('click',function (){
                    categoryInput2.value = li.textContent
                    ul.innerHTML=''
                })
                ul.appendChild(li)
            }
        }
    })

    let subcategoryInput1 = document.getElementById('subcategoryInput1')
    subcategoryInput1.addEventListener('input',function (){
        let ul = document.getElementById('subcategoryList1')
        ul.innerHTML=''
        if(this.value){
            let filtered = {!! $subcategoryNames !!}.filter(function (name){
                return name['name'].startsWith(subcategoryInput1.value)
            })
            for (let filteredElement of filtered) {
                let li = document.createElement('li')
                li.textContent = filteredElement['name']
                li.addEventListener('click',function (){
                    subcategoryInput1.value = li.textContent
                    ul.innerHTML=''
                })
                ul.appendChild(li)
            }
        }
    })

    moreButton.addEventListener('click', function () {
        number++;
        let form = document.querySelector('form');
        let input = document.createElement('input');
        let nameLabel = document.createElement('label');
        let dataLabel = document.createElement('label');
        nameLabel.textContent = 'Название свойства:';
        nameLabel.setAttribute('required', 'required');
        dataLabel.textContent = 'Описание';
        let textArea = document.createElement('textarea');
        input.addEventListener('input', function () {
            textArea.setAttribute('name', this.value);
        });
        let header = document.createElement('h4')
        header.textContent = "Дополнительное свойство: "+number
        input.id = "name_"+number.toString()
        textArea.id = "data_"+number.toString()
        nameLabel.setAttribute('for',input.id)
        dataLabel.setAttribute('for',textArea.id)
        let deleteButton = document.createElement('button');
        deleteButton.setAttribute('class','delete')
        deleteButton.textContent = 'Удалить свойство';
        deleteButton.addEventListener('click', function () {
            nameLabel.remove();
            dataLabel.remove();
            textArea.remove();
            input.remove();
            deleteButton.remove();
            number--;
        });
        form.insertBefore(header, moreButton);
        form.insertBefore(nameLabel, moreButton);
        form.insertBefore(input, moreButton);
        form.insertBefore(dataLabel, moreButton);
        form.insertBefore(textArea, moreButton);
        form.insertBefore(deleteButton, moreButton);
    });
</script>

