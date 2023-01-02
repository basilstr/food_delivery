<?php

namespace App\Entity;

use App\Models\Permanent\Week;

class Schedule implements ComparebleInterface
{
    private $start;
    private $finish;
    private $week;
    private $format;

    public function __construct($attr = null)
    {
        $json = [];
        if($attr) {
            try {
                if(is_array($attr)){
                    $json = $attr;
                }else{
                    $json = json_decode($attr, true);
                }
            } catch (\Exception $e) {
                $json = [];
            }
        }
        $this->start = $json['start'] ?? null;
        $this->finish = $json['finish'] ?? null;
        // заповнення днів тижня
        for ($i=1; $i<8; $i++) {
            $this->week[$i]['from'] = $json[$i]['from'] ?? null;
            $this->week[$i]['to'] = $json[$i]['to'] ?? null;
        }
        $this->format = 'Y-m-d H:i';
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public static function make($data)
    {
        $model = new self();
        $model->start = isset($data['start']) ? strtotime($data['start']) : null;
        $model->finish = isset($data['finish']) ? strtotime($data['finish']) : null;
        // заповнення днів тижня
        for ($i=1; $i<8; $i++) {
            $model->week[$i]['from'] = null;
            $model->week[$i]['to'] =  null;
            if(isset($data[$i])) {
                $fromTo = explode('-', $data[$i]);
                $model->week[$i]['from'] = isset($fromTo[0]) ? trim($fromTo[0]) : null;
                $model->week[$i]['to'] = isset($fromTo[1]) ? trim($fromTo[1]) : null;
            }
        }
        return $model;
    }

    public function toArray()
    {
        $res['start'] = $this->start;
        $res['finish'] = $this->finish;
        for ($i=1; $i<8; $i++) {
            $res[$i]['from'] =  $this->week[$i]['from'];
            $res[$i]['to'] =  $this->week[$i]['to'];
        }
        return $res;
    }

    /**
     * параметр $show дозволяє видавати текстове значення вихідних, в БД = 00:00 - 00:00
     * @param bool $show
     * @return mixed
     */
    public function toFormatArray($show = false)
    {
        $res['start'] = $this->start ? date($this->format, $this->start) : '';
        $res['finish'] = $this->finish ? date($this->format, $this->finish) : '';
        for ($i = 1; $i < 8; $i++) {
            $res[$i] = $show ? 'цілий день' : '';
            if ($this->week[$i]['from'] || $this->week[$i]['to']) {
                $from = $this->week[$i]['from'] ?? '';
                $to = $this->week[$i]['to'] ?? '';
                if ($from == '00:00' && $to == '00:00') {
                    $res[$i] = $show ? 'вихідний' : $from . '-' . $to;
                } else {
                    $res[$i] = $from . '-' . $to;
                }
            }
        }
        return $res;
    }


    /**
     * активність графіку по відношенню до зараз
     * @return bool
     */
    public function isActive()
    {
        if ($this->start && $this->start > time()) return false;
        if ($this->finish && $this->finish < time()) return false;
        $num_week = date('N', time());
        if($this->week[$num_week]['from']){
            $currentDateTime = strtotime(date('Y-m-d')  ." ". $this->week[$num_week]['from']);
            if ($currentDateTime > time()) return false;
        }
        if($this->week[$num_week]['to']){
            $currentDateTime = strtotime(date('Y-m-d')  ." ". $this->week[$num_week]['to']);
            if ($currentDateTime < time()) return false;
        }
        return true;
    }

    /**
     * показує чи підходить графік $schelule у якості підпорядкованого
     * @param Schedule $schedule
     * @return bool
     */
    public function includeSchedule(Schedule $schedule)
    {
        if ($this->start && $schedule->start && $this->start > $schedule->start) return false;
        if ($this->finish && $schedule->finish && $this->finish > $schedule->finish) return false;
        for ($num_week = 1; $num_week < 8; $num_week++) {
            if ($this->week[$num_week]['from'] && $schedule->week[$num_week]['from']) {
                $thisDateTime = strtotime(date('Y-m-d') . " " . $this->week[$num_week]['from']);
                $scheluleDateTime = strtotime(date('Y-m-d') . " " . $schedule->week[$num_week]['from']);
                if ($thisDateTime > $scheluleDateTime) return false;
            }
            if ($this->week[$num_week]['to'] && $schedule->week[$num_week]['to']) {
                $thisDateTime = strtotime(date('Y-m-d') . " " . $this->week[$num_week]['to']);
                $scheluleDateTime = strtotime(date('Y-m-d') . " " . $schedule->week[$num_week]['to']);
                if ($thisDateTime > $scheluleDateTime) return false;
            }
        }
        return true;
    }

    public function hasDiff($data)
    {
        $schedule = new self($data);
        if ($this->start != $schedule->start) return true;
        if ($this->finish != $schedule->finish) return true;
        for ($num_week = 1; $num_week < 8; $num_week++) {
            if ($this->week[$num_week]['from'] != $schedule->week[$num_week]['from']) return true;
            if ($this->week[$num_week]['to'] != $schedule->week[$num_week]['to']) return true;
        }
        return false;
    }

    /**
     * Масив змін для відображення історії
     * @param $data_1
     * @param $data_2
     * @return array
     */
    public static function getDiffArray($data_1, $data_2)
    {
        $res =[];
        $schedule_1 = new self($data_1);
        $schedule_2 = new self($data_2);
        if ($schedule_1->start != $schedule_2->start) {
            $old = isset($schedule_1->start) ? date('Y-m-d', $schedule_1->start) : '-';
            $new = isset($schedule_2->start) ? date('Y-m-d', $schedule_2->start) : '-';
            $res[]=[
                'old' =>'Загальний початок '.$old,
                'new' =>$new,
            ];
        }
        if ($schedule_1->finish != $schedule_2->finish) {
            $old = isset($schedule_1->finish) ? date('Y-m-d', $schedule_1->finish) : '-';
            $new = isset($schedule_2->finish) ? date('Y-m-d', $schedule_2->finish) : '-';
            $res[]=[
                'old' =>'Загальний кінець '.$old,
                'new' =>$new,
            ];
        }
        $week = Week::getList('full');
        for ($num_week = 1; $num_week < 8; $num_week++) {
            if ($schedule_1->week[$num_week]['from'] != $schedule_2->week[$num_week]['from']) {
                $old = $schedule_1->week[$num_week]['from'] ?? '-';
                $new = $schedule_2->week[$num_week]['from'] ?? '-';
                $res[]=[
                    'old' =>$week[$num_week].' початок '.$old,
                    'new' =>$new,
                ];
            }
            if ($schedule_1->week[$num_week]['to'] != $schedule_2->week[$num_week]['to'])  {
                $old = $schedule_1->week[$num_week]['to'] ?? '-';
                $new = $schedule_2->week[$num_week]['to'] ?? '-';
                $res[]=[
                    'old' =>$week[$num_week].' кінець '.$old,
                    'new' =>$new,
                ];
            }
        }
        return $res;
    }
}
