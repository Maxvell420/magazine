<x-layout :styles="$styles" :title="$title">
    <x-adminHeader/>
    <div class="wrapper">
        <div class="form">
            <h3>{{trans('product.create')}}</h3>
            <form action="{{route(trans('test.productSave.name'))}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="name">{{trans('product.name')}}</label>
                <input type="text" name="name" id="name" value="{{old('name')}}">
                <label for="subcategoryInput1">{{trans('product.subcategory')}}</label>
                <input type="text" id="subcategoryInput1" value="{{old('subcategory')}}">
                <input type="hidden" id="subcategory" name="subcategory" value="{{old('subcategory')}}">
                <ul id="subcategoryList1" class="dropdown"></ul>
                <label for="price">{{trans('product.price')}}</label>
                <input type="number" id="price" name="price" min="1" value="{{old('price')}}">
                <label for="quantity">{{trans('product.quantity')}}</label>
                <input type="number" id="quantity" name="quantity" value="{{old('quantity')}}">
                <label for="file">{{trans('product.photo')}}</label>
                <input type="file" id="file" name="images[]" value="{{old('images[]')}}">
                <button type="button" id="more">{{trans('product.more')}}</button>
                <button type="submit" id="save">{{trans('product.save')}}</button>
            </form>
        </div>
        <div class="form">
            <h3>{{trans('category.create')}}</h3>
            <form action="{{route(trans('test.categorySave.name'))}}"method="post">
                @csrf
                <label for="name">{{trans('category.name')}}</label>
                <input type="text" name="name" id="name">
                <button type="submit" id="save">{{trans('category.save')}}</button>
            </form>
        </div>
        <div class="form">
            <h3>{{trans('subcategory.create')}}</h3>
            <form action="{{route(trans('test.subcategorySave.name'))}}" method="post">
                @csrf
                <label for="categoryInput2">{{trans('category.name')}}</label>
                <input type="text" id="categoryInput2" name="category" placeholder="Категория">
                <ul id="categoryList2" class="dropdown"></ul>
                <label for="name">{{trans('subcategory.name')}}</label>
                <input type="text" name="name" id="name">
                <button type="submit" id="save">{{trans('subcategory.save')}}</button>
            </form>
        </div>
    </div>
</x-layout>

<script>
    window.productTranslations = @json(__('product'));
    let translations = window.productTranslations
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
    let hiddenInput = document.getElementById('subcategory')
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
                    hiddenInput.value = filteredElement['id']
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
        nameLabel.textContent = translations.propertyName;
        nameLabel.setAttribute('required', 'required');
        dataLabel.textContent = translations.description;
        let textArea = document.createElement('textarea');
        input.addEventListener('input', function () {
            textArea.setAttribute('name', this.value);
        });
        let header = document.createElement('h4')
        header.textContent = translations.additionalProperty+number
        input.id = "name_"+number.toString()
        textArea.id = "data_"+number.toString()
        nameLabel.setAttribute('for',input.id)
        dataLabel.setAttribute('for',textArea.id)
        let deleteButton = document.createElement('button');
        deleteButton.setAttribute('class','delete')
        deleteButton.textContent = translations.deleteProperty;
        deleteButton.addEventListener('click', function () {
            nameLabel.remove();
            dataLabel.remove();
            textArea.remove();
            input.remove();
            deleteButton.remove();
            header.remove()
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

