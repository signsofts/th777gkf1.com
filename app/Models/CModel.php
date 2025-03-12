<?php

use CodeIgniter\Model;

class CModel extends Model
{
    public $DBs = NULL;
    // public $DBs = NULL;
    private $PRIMARY_KEY = NULL;
    private $sPRIMARY_KEY = NULL;
    private $sTABLE_NAME = NULL;
    private $last_query = NULL;


    public function __construct($TABLE = NULL, $ID = NULL, $TYPE_DB =  null)
    {
        parent::__construct();
        $this->setPRIMARY_KEY(isset($ID) ? $ID : NULL);
        $this->setSTABLE_NAME(isset($TABLE) ? $TABLE : NULL);
        if (is_null($TYPE_DB)) {
            $this->DBs = $this->db;
        } else {
            $this->DBs = $this->load->database($TYPE_DB, TRUE);
        }
    }

    public function __destruct()
    {
        // $this->db->close();
        // $this->db->close ();
    }

    public function TB_NAME()
    {
        return sprintf("%s", $this->sTABLE_NAME);
    }
    public function LastID()
    {
        $temp = new stdClass();
        $this->DBs->select(sprintf("MAX(%s.%s) AS MAX_ID", $this->TB_NAME(), $this->sPRIMARY_KEY));
        $this->DBs->from(sprintf("%s as %s", $this->TB_NAME(), $this->TB_NAME()));

        $query = $this->DBs->get();

        $temp = $query->row_object();
        if ($temp !== NULL) {
            if ($temp->MAX_ID == NULL)
                return 0;
            else
                return $temp->MAX_ID;
        } else {
            return 0;
        }
    }
    /**
    [ 
            "fide"  => 'value',
            "fide1" => 'value1',
            "fide2" => 'value2',
        ];
     */
    public function InsertResources($data = array())
    {

        $ex = [
            "fide"  => 'value',
            "fide1" => 'value1',
            "fide2" => 'value2',
        ];

        if (!empty($data)) {
            try {
                $this->DBs->insert($this->TB_NAME(), $data);
                return $this->DBs->insert_id();
            } catch (Exception $e) {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }


    public function QuerySQL($sql, $row = FALSE)
    {
        try {
            $query = $this->DBs->query($sql);
            if ($this->DBs->affected_rows()) {
                return ['sucess' => 'RUN SUCCESS'];
            } else {
                if ($row) {
                    return $query->row();
                } else {
                    return $query->result();
                }
            }
        } catch (Exception $e) {
            return ["Error" => $e];
        }
    }

    /**  
    "WHERE"  => [
                "key" => "VALUE"
    ],
    "UPDATE" => [
        "key" => "VALUE",
    ],
     */
    public function UpdateResources($temp_data = array())
    {
        $example   = [
            "WHERE"  => [
                "key" => "VALUE"
            ],
            "UPDATE" => [
                "key" => "VALUE",
            ],
        ];
        $temp_data = (object) $temp_data;

        $WHERE = isset($temp_data->WHERE) ? $temp_data->WHERE : array();
        $DATA  = isset($temp_data->UPDATE) ? $temp_data->UPDATE : array();
        $TABLE = isset($temp_data->TABLE) ? $temp_data->TABLE : $this->TB_NAME();

        if (!empty($WHERE)) {
            foreach ($WHERE as $key_WHERE => $item_WHERE) :
                $this->DBs->where(sprintf("%s", $key_WHERE), $item_WHERE);
            endforeach;
        }

        if (!empty($DATA)) {


            foreach ($DATA as $key_DATA => $item_DATA) :
                $this->DBs->set(sprintf("%s", $key_DATA), $item_DATA);
            endforeach;
        }

        if (!empty($TABLE && !empty($DATA))) {

            try {
                $this->DBs->update($TABLE);
                return TRUE;
            } catch (Exception $e) {
                return FALSE;
            }
        }

        return FALSE;
    }
    public function DeleteResources($temp_data = array())
    {
        $ex = [
            "WHERE" => [
                "COLUMN_NAME" => "value",
            ]
        ];

        if (empty($temp_data)) {
            return FALSE;
        } else {
            $temp_data = (object) $temp_data;
        }


        try {
            $WHERE = isset($temp_data->WHERE) ? $temp_data->WHERE : array();
            $TABLE = isset($temp_data->TABLE) ? $temp_data->TABLE : $this->TB_NAME();
            if (!empty($WHERE)) {
                foreach ($WHERE as $ki => $ii) :
                    $this->DBs->where($ki, $ii);
                endforeach;
            }
            $this->DBs->delete($TABLE);

            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }


    /** [ 
        "JOIN"     => [ 
            "Tabel Name"             => [ 
                "ON"    => "Find Name",
                "TYPE"  => "INNER|LEFT|RIGHT|FULL",
                "TABLE" => NULL | 'Tabel Name',
                "KEY"   => NULL | "Find Name",
                "COND"  => [ 
                    // A.a = B.b OR A.a = C.c
                    "AND" => TRUE | FALSE,
                    "ON"  => "string" | [ 'srting' ]
                ]
            ],
            "Tabel Name => TabelNew" => [ 
                "ON"    => "Find Name",
                "TYPE"  => "INNER|LEFT|RIGHT|FULL",
                "TABLE" => NULL | 'Tabel Name',
                "KEY"   => NULL | "Find Name",
                "COND"  => [ 
                    // A.a = B.b OR A.a = C.c
                    "AND" => TRUE | FALSE,
                    "ON"  => "string" | [ 'srting' ]
                ]
            ],
            "SQL|TEXT"               => "SQL TEXT" | [ "SQL TEXT" ],
        ],
        "GROUP_BY" => [ 
            "Tabel Name" => 'sting' | [ "Find Name" ],
            "SQL|TEXT"   => "SQL TEXT" | [ "SQL TEXT" ],
        ],
        "SELECT"   => [ 
            "Tabel Name"            => "Find Name",
            "Tabel Name2"           => [ 
                "Find Name",
                "Find Name AS NEW_NAME",
                "NOT SELECT" => [ "Find Name A", "Find Name B" ],
            ],
            "SUM|MAX|MIN|AVG|COUNT" => "Find Name" | [ "Find Name" | "Find Name AS NEW_NAME" ],
            "SQL|TEXT"              => "SQL TEXT" | [ "SQL TEXT" ],
        ],
        "WHERE"    => [ 
            "TABLE"    => [ 
                //เริ่มต้นเป็น AND
                "Find Name"   => "VALUE" | "NULL" | "IS NOT NULL" | NULL | [ "VALUE", "VALUE" ],
                // != (==) > < ..... "NULL"( IS NULL)
                "Find Name2"  => [ 
                    "DATA"  =>
                        "VALUE" | "NULL" | NULL | "limit,start" | [ "VALUE", "VALUE" ],
                    "COND"  => "AND" | "OR" | "IN" | "OR_IN" | "NOT_IN" | "OR_NOT_IN" | "LINK" | "OR_LINK" | "NOT_LINK" | "OR_NOT_LINK" | "LIMIT",
                    "GROUP" => "OR" | "OR_NOT" | "AND" | "NOT" | FALSE
                ],
                // กรณี COND => LIMIT : DATA => "limit,start" แทนที่ limit,start ด้วย ตัวเลข 
                "GROUPS,1-10" => [ 
                    "JOIN,"       => "OR" || "AND",

                    "Find Name"   => "VALUE" | "NULL" | NULL | [ "VALUE", "VALUE" ],
                    "Find Name2"  => [ 
                        "DATA"  => "VALUE" | "NULL" | NULL | [ "VALUE", "VALUE" ],
                        "COND"  => "AND" | "OR" | "IN" | "OR_IN" | "NOT_IN" | "OR_NOT_IN" | "LINK" | "OR_LINK" | "NOT_LINK" | "OR_NOT_LINK",
                        "GROUP" => "OR" | "OR_NOT" | "AND" | "NOT" | FALSE
                    ],
                    "GROUPS,1-10" => [ 
                        "JOIN,"      => "OR" || "AND",
                        "Find Name"  => "VALUE" | "NULL" | NULL | [ "VALUE", "VALUE" ],
                        "Find Name2" => [ 
                            "DATA"  => "VALUE" | "NULL" | NULL | [ "VALUE", "VALUE" ],
                            "COND"  => "AND" | "OR" | "IN" | "OR_IN" | "NOT_IN" | "OR_NOT_IN" | "LINK" | "OR_LINK" | "NOT_LINK" | "OR_NOT_LINK",
                            "GROUP" => "OR" | "OR_NOT" | "AND" | "NOT" | FALSE
                        ],
                    ],
                ],
            ],
            "SQL|TEXT" => "SQL TEXT" | [ "SQL TEXT" ],
        ],
        "ORDER_BY" => [ 
            "TABLE_NAME" => 'string ASC' | [ 
                "KET" => "DESC" | 'ASC'
            ],
            "SQL|TEXT"   => "SQL TEXT" | [ "SQL TEXT" ],
        ],
        "TABLE"    => 'TABLE_NAME',
        "RETURN"   => "object" | "array",
        "ROW"      => FALSE | TRUE,
    ]*/
    public function QuerySources($DataArray = array())
    {
        // $examp = ;



        $results = array();
        $query   = NULL;

        $JOIN     = array();
        $GROUP_BY = array();
        $SELECT   = array();
        $WHERE    = array();
        $ORDER_BY = array();

        $RETURN = 'object';
        $ROW    = FALSE;

        if (empty($DataArray)) {
            $query   = $this->DBs->get($this->TB_NAME());
            $results = $query->result_object();
            $this->setLast_query($this->DBs->last_query());

            return $results;
        } else {
            $DataArray = (object) $DataArray;
        }

        $SELECT   = isset($DataArray->SELECT) ? $DataArray->SELECT : array();
        $JOIN     = isset($DataArray->JOIN) ? $DataArray->JOIN : array();
        $WHERE    = isset($DataArray->WHERE) ? $DataArray->WHERE : array();
        $GROUP_BY = isset($DataArray->GROUP_BY) ? $DataArray->GROUP_BY : array();
        $ORDER_BY = isset($DataArray->ORDER_BY) ? $DataArray->ORDER_BY : array();
        $RETURN   = isset($DataArray->RETURN) ? $DataArray->RETURN : 'object';
        $ROW      = isset($DataArray->ROW) ? $DataArray->ROW : FALSE;
        $TABLE    = isset($DataArray->TABLE) ? $DataArray->TABLE : $this->TB_NAME();

        if (!empty($SELECT)) {
            $this->Fn_SELECT($SELECT);
        }
        if (!empty($JOIN)) {
            $this->Fn_JOIN($JOIN);
        }
        if (!empty($WHERE)) {
            $this->Fn_WHERE($WHERE);
        }
        if (!empty($GROUP_BY)) {
            $this->Fn_GROUP_BY($GROUP_BY);
        }
        if (!empty($ORDER_BY)) {
            $this->Fn_ORDER_BY($ORDER_BY);
        }


        try {
            // $this->setLast_query($this->DBs->get_compiled_select());

            $query = $this->DBs->get($TABLE, FALSE);
            $this->setLast_query($this->DBs->last_query());
            $this->DBs->reset_query();

            switch (strtoupper($RETURN)) {
                case 'OBJECT':
                    if ($ROW) {
                        $results = $query->row_object();
                        break;
                    }
                    $results = $query->result_object();
                    break;
                case 'ARRAY':
                    if ($ROW) {
                        $results = $query->row_array();
                        break;
                    }
                    $results = $query->result_array();
                    break;
                default:
                    $results = $query->result_object();
                    break;
            }

            return $results;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public function Fn_ORDER_BY($ORDER_BY = array())
    {
        foreach ($ORDER_BY as $ki => $ii) :
            $_Tabel = $ki;

            switch (strtoupper($_Tabel)) {
                case 'SQL':
                    if (gettype($ii) == 'string') {
                        $this->DBs->order_by(sprintf("%s", $ii), '', FALSE);
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->order_by(sprintf("%s", $ij), '', FALSE);
                        endforeach;
                    }
                    break;
                case 'TEXT':
                    if (gettype($ii) == 'string') {
                        $this->DBs->order_by(sprintf("%s", $ii), '', FALSE);
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->order_by(sprintf("%s", $ij), '', FALSE);
                        endforeach;
                    }
                    break;
                default:
                    if ((strtoupper($_Tabel) != 'SQL' || strtoupper($_Tabel) != 'TEXT') && gettype($ii) == 'string') {
                        $this->DBs->order_by(sprintf("%s.%s", $_Tabel, $ii), '', FALSE);
                        // continue;
                        break;
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->order_by(sprintf("%s.%s", $_Tabel, $kj), $ij, FALSE);
                        endforeach;
                    }
                    break;
            }
        endforeach;
    }
    public function Fn_WHERE($WHERE = array())
    {

        foreach ($WHERE as $ki => $ii) :
            $_Tabel = $ki;
            $_group = explode(",", $_Tabel);
            if (count($_group) == 2) { //กลุ่มนอก รอพัฒนา
                // /กลุ่มนอก รอพัฒนา
                continue;
            }
            switch (strtoupper($_Tabel)) {
                case 'SQL':
                    if (gettype($ii) == 'string') {
                        $this->DBs->where(sprintf("%s", $ii), '', FALSE);
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->where(sprintf("%s", $ij), '', FALSE);
                        endforeach;
                    }
                    break;
                case 'TEXT':
                    if (gettype($ii) == 'string') {
                        $this->DBs->where(sprintf("%s", $ii), '', FALSE);
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->where(sprintf("%s", $ij), '', FALSE);
                        endforeach;
                    }
                    break;
                default:
                    if ((strtoupper($_Tabel) != 'SQL' || strtoupper($_Tabel) != 'TEXT') && gettype($ii) == 'string') {
                        $this->DBs->where(sprintf("%s", $_Tabel, $ii), '', FALSE);
                        // continue;
                        break;
                    } else {
                        foreach ($ii as $kj => $ij) :
                            switch (gettype($ij)) {
                                case 'string':

                                    $ij_val = strtoupper($ij) === 'NULL' ? NULL : $ij;
                                    $this->CONDITION(sprintf("%s.%s", $_Tabel, $kj), "AND", $ij_val);

                                    break;
                                default:
                                    $_group = explode(",", $kj);
                                    if (count($_group) == 2) { //กลุ่มใน
                                        $this->isAddGroups(isset($ij['JOIN,']) ? $ij['JOIN,'] : FALSE);
                                        foreach ($ij as $kk => $ik) :
                                            if ($kk == 'JOIN,') {
                                                // ข้ามการ JOIN
                                                break;
                                            }
                                            $_group_sub = explode(",", $kk); // ตรวจสอบหากลุ่มใหม่
                                            if (count($_group_sub) == 2) { // ตรวจสอบหากลุ่มใหม่
                                                $this->isAddGroups(isset($ik['JOIN,']) ? $ik['JOIN,'] : FALSE);
                                                foreach ($ik as $kl => $il) :
                                                    if ($kl == 'JOIN,') {
                                                        // ข้ามการ JOIN
                                                        break;
                                                    }
                                                    $this->isAddConditton(sprintf("%s.%s", $_Tabel, $kl), $il);
                                                endforeach;
                                                if (isset($ik['JOIN,']) ? $ik['JOIN,'] : FALSE) {
                                                    $this->DBs->group_end();
                                                }
                                                break;
                                            }
                                            $this->isAddConditton(sprintf("%s.%s", $_Tabel, $kk), $ik);
                                        endforeach;
                                        if (isset($ij['JOIN,']) ? $ij['JOIN,'] : FALSE) {
                                            $this->DBs->group_end();
                                        }
                                        break;
                                    }
                                    $this->isAddConditton(sprintf("%s.%s", $_Tabel, $kj), $ij);
                            }
                        endforeach;
                    }
                    break;
            }
        endforeach;
    }

    public function isAddConditton($tabel, $data)
    {
        if (!isset($data['DATA'])) {
            //"Exp" => ['NULL', '00001'],
            $this->CONDITION(sprintf("%s", $tabel), "AND", $data);
        } else {
            // "Exp" => [
            //     "DATA" => ['NULL', '00001'],
            //     "COND" => "and/or/in/or_in/not_in/or_not_in/LIKE/OR_LIKE",
            //     "GROUP" => "OR" | "OR_NOT" | "AND" | "NOT" | false
            // ]
            $_dataCOND  = isset($data['COND']) ? $data['COND'] : "AND";
            $_dataGroup = isset($data['GROUP']) ? strtoupper($data['GROUP']) : FALSE;
            $this->isAddGroups($_dataGroup);
            $this->CONDITION(sprintf("%s", $tabel), $_dataCOND, $data['DATA']);
            if ($_dataGroup != FALSE) {
                $this->DBs->group_end();
            }
        }
    }

    public function isAddGroups($isGroup)
    {
        switch (strtoupper($isGroup)) {
            case 'AND':
                $this->DBs->group_start();
                break;
            case 'OR':
                $this->DBs->or_group_start();
                break;
            case 'OR_NOT':
                $this->DBs->or_group_start();
                break;
            case 'NOT':
                $this->DBs->or_group_start();
                break;
        }
    }

    public function ISNOTNULL($tabel, $cond, $data)
    {
        $this->DBs->where("$tabel $data");
    }
    public function WHERECUM($tabel, $cond, $data)
    {
        $this->DBs->where(sprintf("%s.%s %s", $tabel, $data, $cond));
    }
    public function CONDITION($tabel, $cond, $data)
    {

        // "DATA" => ['NULL', '00001'],
        // "DATA" => "VALUE" || ["VALUE"],
        switch (strtoupper($cond)) {
            case 'AND':
                if (gettype($data) == 'array') {
                    foreach ($data as $kk => $ik) :

                        if (strtoupper($ik) === 'IS NOT NULL') {
                            $this->ISNOTNULL($tabel, 'IS NOT NULL', $ik);
                        } else {
                            $ik_val = strtoupper($ik) === 'NULL' ? NULL : $ik;
                            $this->DBs->where(sprintf("%s", $tabel), $ik_val, gettype($ik_val) == "string" ? TRUE : FALSE);
                        }

                    endforeach;
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;

                    if ($ij_val === 'IS NOT NULL') {
                        $this->ISNOTNULL($tabel, 'IS NOT NULL', $ij_val);
                    } else {
                        $this->DBs->where(sprintf("%s", $tabel), $ij_val, gettype($ij_val) == "string" ? TRUE : FALSE);
                    }
                }
                break;
            case 'OR':
                if (gettype($data) == 'array') {
                    foreach ($data as $kk => $ik) :
                        $ik_val = strtoupper($ik) === 'NULL' ? NULL : $ik;
                        $this->DBs->or_where(sprintf("%s", $tabel), $ik_val, gettype($ik_val) == "string" ? TRUE : FALSE);
                    endforeach;
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->or_where(sprintf("%s", $tabel), $ij_val, gettype($ij_val) == "string" ? TRUE : FALSE);
                }
                break;
            case 'IN':
                if (gettype($data) == 'array') {
                    $this->DBs->where_in(sprintf("%s", $tabel), $data); //, gettype($data) == "string" ? TRUE : TRUE
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->where_in(sprintf("%s", $tabel), $ij_val, gettype($ij_val) == "string" ? TRUE : FALSE);
                }
                break;
            case 'OR_IN':
                if (gettype($data) == 'array') {
                    $this->DBs->or_where_in(sprintf("%s", $tabel), $data); //, gettype($data) == "string" ? TRUE : FALSE
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->or_where_in(sprintf("%s", $tabel), $ij_val, gettype($ij_val) == "string" ? TRUE : FALSE);
                }
                break;
            case 'NOT_IN':
                if (gettype($data) == 'array') {
                    $this->DBs->where_not_in(sprintf("%s", $tabel), $data);
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->where_not_in(sprintf("%s", $tabel), $ij_val, gettype($ij_val) == "string" ? TRUE : FALSE);
                }
                break;
            case 'OR_NOT_IN':
                if (gettype($data) == 'array') {
                    $this->DBs->or_where_not_in(sprintf("%s", $tabel), $data);
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->or_where_not_in(sprintf("%s", $tabel), $ij_val, gettype($ij_val) == "string" ? TRUE : FALSE);
                }
                break;
            case 'LINK':
                if (gettype($data) == 'array') {
                    foreach ($data as $kk => $ik) :
                        $ik_val = strtoupper($ik) === 'NULL' ? NULL : $ik;
                        $this->DBs->like(sprintf("%s", $tabel), $ik_val, gettype($ik_val) == "string" ? TRUE : FALSE);
                    endforeach;
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->like(sprintf("%s", $tabel), $ij_val, 'both');
                }
                break;
            case 'OR_LINK':
                if (gettype($data) == 'array') {
                    foreach ($data as $kk => $ik) :
                        $ik_val = strtoupper($ik) === 'NULL' ? NULL : $ik;
                        $this->DBs->or_like(sprintf("%s", $tabel), $ik_val, gettype($ik_val) == "string" ? TRUE : FALSE);
                    endforeach;
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->or_like(sprintf("%s", $tabel), $ij_val, 'both');
                }
                break;
            case 'NOT_LINK':
                if (gettype($data) == 'array') {
                    foreach ($data as $kk => $ik) :
                        $ik_val = strtoupper($ik) === 'NULL' ? NULL : $ik;
                        $this->DBs->not_like(sprintf("%s", $tabel), $ik_val, gettype($ik_val) == "string" ? TRUE : FALSE);
                    endforeach;
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->not_like(sprintf("%s", $tabel), $ij_val, 'both');
                }
                break;
            case 'OR_NOT_LINK':
                if (gettype($data) == 'array') {
                    foreach ($data as $kk => $ik) :
                        $ik_val = strtoupper($ik) === 'NULL' ? NULL : $ik;
                        $this->DBs->or_not_like(sprintf("%s", $tabel), $ik_val, gettype($ik_val) == "string" ? TRUE : FALSE);
                    endforeach;
                } else {
                    $ij_val = strtoupper($data) === 'NULL' ? NULL : $data;
                    $this->DBs->or_not_like(sprintf("%s", $tabel), $ij_val, 'both');
                }
                break;

            default:
                if (gettype($data) == 'array') {
                    foreach ($data as $kk => $ik) :
                        $this->WHERECUM($tabel, $cond, $ik);
                    endforeach;
                } else {
                    $this->WHERECUM($tabel, $cond, $data);
                }
                break;
        }
    }
    public function Fn_JOIN($JOIN)
    {
        // "JOIN" => [
        //     "TABLE" => [
        //         "ON" => "Find Name",
        //         "TYPE" => "INNER|LEFT|RIGHT|FULL",
        //         "TABLE" => NULL,
        //         "KEY" => NULL,
        //         "COND" => [
        //             "AND" => TRUE | FALSE,
        //             "ON" => "string" | ['srting']
        //         ]
        //     ],
        //     "SQL|TEXT" => "SQL TEXT" | ["SQL TEXT"],
        // ],

        foreach ($JOIN as $ki => $ii) :
            $_Tabel = $ki;

            switch (strtoupper($_Tabel)) {
                case 'SQL':
                    if (gettype($ii) == 'string') {
                        $ex      = explode(',', $ii);
                        $_jTabel = $ex[0];
                        $_jOn    = $ex[1];
                        $_jtype  = $ex[2];
                        $this->DBs->join(sprintf("%s", $_jTabel), sprintf("%s", $_jOn), sprintf("%s", $_jtype), FALSE);
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $ex      = explode(',', $ij);
                            $_jTabel = $ex[0];
                            $_jOn    = $ex[1];
                            $_jtype  = $ex[2];
                            $this->DBs->join(sprintf("%s", $_jTabel), sprintf("%s", $_jOn), sprintf("%s", $_jtype), FALSE);
                        endforeach;
                    }
                    break;
                case 'TEXT':
                    if (gettype($ii) == 'string') {
                        $ex      = explode(',', $ii);
                        $_jTabel = $ex[0];
                        $_jOn    = $ex[1];
                        $_jtype  = $ex[2];
                        $this->DBs->join(sprintf("%s", $_jTabel), sprintf("%s", $_jOn), sprintf("%s", $_jtype), FALSE);
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $ex      = explode(',', $ij);
                            $_jTabel = $ex[0];
                            $_jOn    = $ex[1];
                            $_jtype  = $ex[2];
                            $this->DBs->join(sprintf("%s", $_jTabel), sprintf("%s", $_jOn), sprintf("%s", $_jtype), FALSE);

                        endforeach;
                    }
                    break;

                default:
                    $_jTabelBTemAS = explode("=>", $_Tabel);
                    $_jTabelBTemas = explode("=>", $_Tabel);
                    $_jTabelB = $_Tabel;

                    $_jOn = isset($ii['ON']) ? $ii['ON'] : '';
                    $_jTabelA = isset($ii['TABLE']) ? $ii['TABLE'] : $this->TB_NAME();
                    $_jkey = isset($ii['KEY']) ? $ii['KEY'] : $_jOn;
                    $_jtype = isset($ii['TYPE']) ? $ii['TYPE'] : 'INNER';

                    $COND = '';

                    if (isset($ii['COND'])) {
                        $COND_ = isset($ii['COND']) ? $ii['COND'] : [];
                        $COND  = $COND_['AND'] ? " AND " : " OR ";
                        if (gettype($COND_["ON"]) === "string") {
                            $COND .= $COND_["ON"];
                        } else if (!empty($COND_["ON"])) {
                            foreach ($COND_["ON"] as $kj => $ij) :
                                $COND .= $ij;
                            endforeach;
                        }
                    }

                    if (count($_jTabelBTemAS) == 2 || count($_jTabelBTemAS) == 2) {
                        if (count($_jTabelBTemAS) > count($_jTabelBTemAS)) {
                            $_jTabelB   = $_jTabelBTemAS[0];
                            $_jTabelBOn = $_jTabelBTemAS[1];
                        } else {
                            $_jTabelB   = $_jTabelBTemAS[0];
                            $_jTabelBOn = $_jTabelBTemAS[1];
                        }
                    } else {
                        $_jTabelBOn = $_jTabelB;
                    }

                    $ONT = sprintf("%s.%s = %s.%s  %s", $_jTabelA, $_jkey, $_jTabelBOn, $_jOn, $COND);
                    $this->DBs->join(sprintf("%s AS %s", $_jTabelB, $_jTabelBOn), $ONT, sprintf("%s", strtoupper($_jtype)), FALSE);
                    break;
            }
        endforeach;
    }

    /*
        "SELECT" => [
            "TABLE" => "VALUE" |  ["VALUE" | "VALUE AS NEW_NAME"],
            "TABLE" => ["NOT SELECT" => ["fillable A" , "fillable B"]],
            "SQL|TEXT" => "SQL TEXT" | ["SQL TEXT"],
            "MAX|MIN|AVG" => "VALUE" | ["VALUE" | "VALUE AS NEW_NAME"],
        ],
    */
    public function Fn_SELECT($SELECT)
    {
        // "SELECT" => [
        //     "TABLE" => "VALUE" |  ["VALUE" | "VALUE AS NEW_NAME"],
        //  "TABLE" => ["NOT SELECT" => ["fillable A" , "fillable B"]],
        //     "SQL|TEXT" => "SQL TEXT" | ["SQL TEXT"],
        //     "MAX|MIN|AVG" => "VALUE" | ["VALUE" | "VALUE AS NEW_NAME"],
        // ],

        foreach ($SELECT as $ki => $ii) :
            $_Tabel = $ki;

            switch (strtoupper($_Tabel)) {
                case 'SQL':
                    if (gettype($ii) == 'string') {
                        $this->DBs->select(sprintf("%s", $ii), FALSE);
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->select(sprintf("%s", $ij), FALSE);
                        endforeach;
                    }
                    break;
                case 'TEXT':
                    if (gettype($ii) == 'string') {
                        $this->DBs->select(sprintf("%s", $ii), FALSE);
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->select(sprintf("%s", $ij), FALSE);
                        endforeach;
                    }
                    break;
                case 'MAX':
                    if (gettype($ii) == 'string') {
                        $this->DBs->select_max(sprintf("%s", $ii));
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->select_max(sprintf("%s", $ij));
                        endforeach;
                    }
                    break;
                case 'MIN':
                    if (gettype($ii) == 'string') {
                        $this->DBs->select_min(sprintf("%s", $ii));
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->select_min(sprintf("%s", $ij));
                        endforeach;
                    }
                    break;
                case 'AVG':
                    if (gettype($ii) == 'string') {
                        $this->DBs->select_avg(sprintf("%s", $ii));
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->select_avg(sprintf("%s", $ij));
                        endforeach;
                    }
                    break;
                case 'SUM':
                    if (gettype($ii) == 'string') {
                        $this->DBs->select_sum(sprintf("%s", $ii));
                    } else {
                        foreach ($ii as $kj => $ij) :
                            $this->DBs->select_sum(sprintf("%s", $ij));
                        endforeach;
                    }
                    break;
                case 'COUNT':
                    // if (gettype($ii) == 'string') {
                    //     $this->DBs->select("cou");

                    // } else {
                    // foreach ($ii as $kj => $ij):
                    //     $this->DBs->select_sum(sprintf("%s", $ij));
                    // endforeach;
                    // }
                    break;
                case 'LIMIT':

                    switch (gettype($ii)) {

                        case 'string':
                            $li = explode(',', $ii);
                            $this->DBs->limit($li[0], $li[1]);
                            break;
                        case 'integer':
                            $this->DBs->limit($ii, 0);
                            break;
                    }

                    break;
                default:
                    if ((strtoupper($_Tabel) != 'SQL' || strtoupper($_Tabel) != 'TEXT') && gettype($ii) == 'string') {
                        // ถ้ามไม่เป็น Array Select 1 fillable
                        $this->DBs->select(sprintf("%s.%s", $_Tabel, $ii), FALSE);
                        break;
                    } else {
                        foreach ($ii as $kj => $ij) :

                            if (strtoupper($kj) == 'NOT SELECT') {

                                $NotC       = new C_MODELS("INFORMATION_SCHEMA.COLUMNS");
                                $NOT_SELECT = $NotC->QuerySources([
                                    "GROUP_BY" => [
                                        "SQL" => "COLUMN_NAME,TABLE_NAME"
                                    ],
                                    "WHERE"    => [
                                        "SQL" => "TABLE_NAME = N'$_Tabel'",
                                    ]
                                ]);

                                $nSelect = array();
                                $Select  = array();

                                foreach ($NOT_SELECT as $kk => $ik) :
                                    array_push($nSelect, $ik->COLUMN_NAME);
                                endforeach;

                                if (gettype($ij) == 'string') {
                                    $Select = array_diff($nSelect, [$ij]);
                                } else if (gettype($ij) == 'array') {
                                    $Select = array_diff($nSelect, $ij);
                                }

                                foreach ($Select as $kl => $il) :
                                    $this->DBs->select(sprintf("%s.%s", $_Tabel, $il), FALSE);
                                endforeach;

                                unset($NotC);
                            } else if (gettype($ij) == 'string') {
                                $this->DBs->select(sprintf("%s.%s", $_Tabel, $ij), FALSE);
                            } else {
                                foreach ($ij as $kk => $ik) :
                                    $this->DBs->select(sprintf("%s.%s", $_Tabel, $ik), FALSE);
                                endforeach;
                            }
                        endforeach;
                    }
                    break;
            }
        endforeach;
    }

    public function Fn_GROUP_BY($GROUP_BY)
    {
        // "GROUP_BY" => [
        //     "TABLE" => 'sting' | ["Find Name"],
        //     "SQL" => "SQL TEXT" | ["SQL TEXT"],
        // ],
        foreach ($GROUP_BY as $ki => $ii) :

            $_Tabel = $ki;
            if (strtoupper($_Tabel) == 'SQL' || strtoupper($_Tabel) == 'TEXT') {
                if (gettype($ii) == 'string') {

                    if (empty($SELECT)) {
                        $this->DBs->select($ii);
                    }
                    $this->DBs->group_by(sprintf("%s", $ii), FALSE);
                } else {
                    foreach ($ii as $kj => $ij) :

                        if (empty($SELECT)) {
                            $this->DBs->select($ij);
                        }
                        $this->DBs->group_by(sprintf("%s", $ij), FALSE);

                    endforeach;
                }
                continue;
            }

            if ((strtoupper($_Tabel) != 'SQL' || strtoupper($_Tabel) != 'TEXT') && gettype($ii) == 'string') {
                if (empty($SELECT)) {
                    $this->DBs->select(sprintf("%s.%s", $_Tabel, $ii), FALSE);
                }
                $this->DBs->group_by(sprintf("%s.%s", $_Tabel, $ii), FALSE);
                continue;
            }

            foreach ($ii as $kj => $ij) :
                if (gettype($ij) == 'string') {
                    if (empty($SELECT)) {
                        $this->DBs->select(sprintf("%s.%s", $_Tabel, $ij), FALSE);
                    }
                    $this->DBs->group_by(sprintf("%s.%s", $_Tabel, $ij), FALSE);
                } else {
                    foreach ($ij as $kk => $ik) :

                        if (empty($SELECT)) {
                            $this->DBs->select(sprintf("%s.%s", $_Tabel, $ik), FALSE);
                        }
                        $this->DBs->group_by(sprintf("%s.%s", $_Tabel, $ik), FALSE);
                    endforeach;
                }
            endforeach;
        endforeach;
    }

    /**
     * Get the value of PRIMARY_KEY
     */
    public function getPRIMARY_KEY()
    {
        return $this->PRIMARY_KEY;
    }

    /**
     * Set the value of PRIMARY_KEY
     *
     * @return  self
     */
    public function setPRIMARY_KEY($PRIMARY_KEY)
    {
        $this->PRIMARY_KEY  = $PRIMARY_KEY;
        $this->sPRIMARY_KEY = $PRIMARY_KEY;

        return $this;
    }


    /**
     * Get the value of sTABLE_NAME
     */
    public function getSTABLE_NAME()
    {
        return $this->sTABLE_NAME;
    }

    /**
     * Set the value of sTABLE_NAME
     *
     * @return  self
     */
    public function setSTABLE_NAME($sTABLE_NAME)
    {
        $this->sTABLE_NAME = $sTABLE_NAME;

        return $this;
    }

    /**
     * Get the value of last_query
     */
    public function getLast_query()
    {
        return $this->last_query;
    }


    /**
     * Set the value of last_query
     *
     * @return  self
     */
    public function setLast_query($last_query)
    {
        $this->last_query = $last_query;

        return $this;
    }


    //-------------------------------------------------------------------------


    public function querydata($sql)
    {

        try {
            $query = $this->DBs->query($sql);
            if ($this->DBs->affected_rows()) {
                return ['sucess' => 'RUN SUCCESS'];
            } else {
                return $query->result();
            }
        } catch (Exception $e) {
            return ["Error" => $e];
        }
    }
}
