<x-content>
    @if($house->user->frozen)
        <x-frozenUser :house="$house"/>
        @else
        <x-house.preview.complete :house="$house" :watchlist="$watchlist"/>
        <div class="chat">
            <div class="messages">
                @foreach($chat->messages as $message)
                    @if($user->id==$message->user->id)
                        <div class="userMessage">
                            {{$message->text}}
                        </div>
                    @else
                        <div class="message">
                            <span class="from">{{$message->user->name}}</span>
                            <span>{{$message->text}}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <form action="{{route('message.create',$chat)}}" method="post">
            @csrf
            <label>
                <textarea name="text"></textarea>
            </label>
            <input type="submit" @if($house->archived) disabled
                   value="archived" @else value="send message @endif">
        </form>
    @endif
</x-content>
<script>
    let maxColor = 220;
    let minColor = 100;
    let chat = document.querySelector('.chat');
    scrollToBot();
    let currentHeight = chat.scrollTop;
    let messages = Array.from(document.querySelectorAll('.chat .userMessage'));
    let messagesRev = messages.slice().reverse();

    function getVisibleMessages(chat, messages) {
        let chatRect = chat.getBoundingClientRect();
        let result = [];
        for (let message of messages) {
            let messageRect = message.getBoundingClientRect();
            if (messageRect.top >= chatRect.top && messageRect.bottom <= chatRect.bottom) {
                result.push(message);
            }
        }
        return result;
    }

    function calcScroll() {
        return currentHeight - chat.scrollTop;
    }

    function changeColor() {
        let heightChange = calcScroll();
        let colorMessages = getVisibleMessages(chat, messages);
        if (heightChange > 2) {
            currentHeight = chat.scrollTop;
            for (let colorMessage of colorMessages) {
                let cssStyles = window.getComputedStyle(colorMessage);
                let background = cssStyles.getPropertyValue('background-color');
                let rgb = background.match(/\d+/g).map(Number);
                let firstColor = rgb[0];
                if (firstColor === maxColor) {
                    continue;
                }
                firstColor += 5;
                colorMessage.style.backgroundColor = `rgb(${firstColor}, 83, 227)`;
                if (firstColor === (minColor - 5)) {
                    break;
                }
            }
        } else if (heightChange < -2) {
            currentHeight = chat.scrollTop;
            for (let colorMessage of colorMessages.reverse()) {
                let cssStyles = window.getComputedStyle(colorMessage);
                let background = cssStyles.getPropertyValue('background-color');
                let rgb = background.match(/\d+/g).map(Number);
                let firstColor = rgb[0];
                if (firstColor === minColor) {
                    continue;
                }
                firstColor -= 5;
                colorMessage.style.backgroundColor = `rgb(${firstColor}, 83, 227)`;
                if (firstColor === (maxColor + 5)) {
                    break;
                }
            }
        }
    }

    function scrollToBot() {
        chat.scrollTop = chat.scrollHeight;
    }

    chat.addEventListener('scroll', changeColor);
</script>
