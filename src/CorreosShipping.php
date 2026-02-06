<?php

namespace SmartDato\CorreosShipping;

use SmartDato\CorreosShipping\Connectors\LabelsConnector;
use SmartDato\CorreosShipping\Connectors\PreregisterConnector;
use SmartDato\CorreosShipping\Connectors\TrackingConnector;
use SmartDato\CorreosShipping\Resources\LabelsResource;
use SmartDato\CorreosShipping\Resources\PreregisterResource;
use SmartDato\CorreosShipping\Resources\TrackingResource;

class CorreosShipping
{
    public function __construct(
        protected PreregisterConnector $preregisterConnector,
        protected LabelsConnector $labelsConnector,
        protected TrackingConnector $trackingConnector,
    ) {}

    public function preregister(): PreregisterResource
    {
        return new PreregisterResource($this->preregisterConnector);
    }

    public function labels(): LabelsResource
    {
        return new LabelsResource($this->labelsConnector);
    }

    public function tracking(): TrackingResource
    {
        return new TrackingResource($this->trackingConnector);
    }
}
