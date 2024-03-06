<x-content>
    <x-house :house="$house"/>
    <form action="{{route('complaint.save',$house)}}" method="post">
        @csrf
        <label>
            <textarea name="text">{{old('text')}}</textarea>
        </label>
        <input type="submit" value="send complaint">
    </form>
</x-content>
