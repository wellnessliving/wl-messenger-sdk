<?php

namespace WellnessLiving\MessengerSdk\Enums;

enum ReactionType: string
{
    case MESSAGE = 'message';
    case CHANNEL = 'channel';
    case CUSTOM = 'custom';
}
