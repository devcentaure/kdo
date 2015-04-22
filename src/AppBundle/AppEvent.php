<?php

namespace AppBundle;

final class AppEvent
{
    /** @ListKdo */
    const ListKdoAdd = 'app.event.addlistkdo';
    const ListKdoUpdate = 'app.event.updatelistkdo';
    const ListKdoDelete = 'app.event.deletelistkdo';


    /** @Kdo */
    const KdoAdd = 'app.event.addkdo';
    const KdoUpdate = 'app.event.updatekdo';
    const KdoDelete = 'app.event.deletekdo';
}
