<?php declare(strict_types=1);

namespace Builder\Domain\Stack\Diff;

use Builder\Domain\Stack\Compose;

final class StackDiff
{
    private Compose\Stack $from;
    private Compose\Stack $to;

    public function __construct(
        Compose\Stack $from,
        Compose\Stack $to
    ) {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return array|Compose\Service[]
     */
    public function extraServices(): array
    {
        $fromServices = array_map(function (Compose\Service $service) {
            return $service->getName();
        }, $this->from->getServices());

        $toServices = array_map(function (Compose\Service $service) {
            return $service->getName();
        }, $this->to->getServices());

        return $this->from->extractServices(...array_diff($fromServices, $toServices));
    }

    /**
     * @return array|Compose\Service[]
     */
    public function missingServices(): array
    {
        $fromServices = array_map(function (Compose\Service $service) {
            return $service->getName();
        }, $this->from->getServices());

        $toServices = array_map(function (Compose\Service $service) {
            return $service->getName();
        }, $this->to->getServices());

        return $this->to->extractServices(...array_diff($toServices, $fromServices));
    }

    /**
     * @return array|Compose\Service[]
     */
    public function commonServices(): array
    {
        $fromServices = array_map(function (Compose\Service $service) {
            return $service->getName();
        }, $this->from->getServices());

        $toServices = array_map(function (Compose\Service $service) {
            return $service->getName();
        }, $this->to->getServices());

        return $this->to->extractServices(...array_intersect($toServices, $fromServices));
    }

    /**
     * @return array|ServiceDiff[]
     */
    public function diffServices(): array
    {
        $fromServices = array_map(function (Compose\Service $service) {
            return $service->getName();
        }, $this->from->getServices());

        $toServices = array_map(function (Compose\Service $service) {
            return $service->getName();
        }, $this->to->getServices());

        $intersect = array_intersect($toServices, $fromServices);

        return array_map(function (Compose\Service $from, Compose\Service $to) {
            return new ServiceDiff($from, $to);
        }, $this->from->extractServices(...$intersect), $this->to->extractServices(...$intersect));
    }

    /**
     * @return array|Compose\Volume[]
     */
    public function extraVolumes(): array
    {
        $fromVolumes = array_map(function (Compose\Volume $volume) {
            return $volume->getName();
        }, $this->from->getVolumes());

        $toVolumes = array_map(function (Compose\Volume $volume) {
            return $volume->getName();
        }, $this->to->getVolumes());

        return $this->from->extractVolumes(...array_diff($fromVolumes, $toVolumes));
    }

    /**
     * @return array|Compose\Volume[]
     */
    public function missingVolumes(): array
    {
        $fromVolumes = array_map(function (Compose\Volume $volume) {
            return $volume->getName();
        }, $this->from->getVolumes());

        $toVolumes = array_map(function (Compose\Volume $volume) {
            return $volume->getName();
        }, $this->to->getVolumes());

        return $this->to->extractVolumes(...array_diff($toVolumes, $fromVolumes));
    }

    /**
     * @return array|Compose\Volume[]
     */
    public function commonVolumes(): array
    {
        $fromVolume = array_map(function (Compose\Volume $volume) {
            return $volume->getName();
        }, $this->from->getServices());

        $toVolume = array_map(function (Compose\Volume $volume) {
            return $volume->getName();
        }, $this->to->getServices());

        return $this->to->extractServices(...array_intersect($toVolume, $fromVolume));
    }

    /**
     * @return array|VolumeDiff[]
     */
    public function diffVolumes(): array
    {
        $fromVolumes = array_map(function (Compose\Volume $volume) {
            return $volume->getName();
        }, $this->from->getVolumes());

        $toVolumes = array_map(function (Compose\Volume $volume) {
            return $volume->getName();
        }, $this->to->getVolumes());

        $intersect = array_intersect($toVolumes, $fromVolumes);

        return array_map(function (Compose\Volume $from, Compose\Volume $to) {
            return new VolumeDiff($from, $to);
        }, $this->from->extractVolumes(...$intersect), $this->to->extractVolumes(...$intersect));
    }
}