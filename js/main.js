function changeCurrent(ch)
{
    switch (ch) {
        case 'card':
            logo.className = "pagename";
            card.className = "current";
            break;
        case 'test':
            logo.className = "pagename";
            test.className = "current";
            break;
    }
}
