<?php

namespace SmartDato\CorreosShipping\Enums;

/**
 * MDP product codes (Annex I - Products table).
 *
 * This is not exhaustive — Correos may offer additional products
 * depending on your contract. Use the string value directly if
 * your product code is not listed here.
 */
enum ProductCode: string
{
    // Nacional - Paquetería
    case PaqPremium = 'PAFXB';
    case PaqEstandar = 'PAAZE';
    case PaqToday = 'PADXA';
    case PaqRetorno = 'PARC';
    case PaqEmpresa14 = 'S0132';
    case PaqEmpresa24 = 'S0235';
    case PaqLigero = 'S0236';

    // Nacional - Paquetería XL
    case PaqPremiumXL = 'PPFXB';
    case PaqEstandarXL = 'PPAZE';

    // Nacional - Postal
    case CartaCertificada = 'S0148';
    case CartaCertificadaUrgente = 'S0150';
    case Notificaciones = 'S0175';
    case PaqueteAzul = 'PQDOM';

    // Internacional - Paquetería
    case PaqInternacionalExpress = 'POAXAC';
    case PaqInternacionalEstandar = 'POAZE';
    case PaqInternacionalPremium = 'POAFXB';

    // Internacional - Postal (EMS / Postal Exprés)
    case EmsPostalExpres = 'S0076';
    case PaqueteInternacionalEconomico = 'S0108';
    case PaqueteInternacionalPrioritario = 'S0107';
}
