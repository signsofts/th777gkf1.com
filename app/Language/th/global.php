<?php
return [
    "T1" => "รายละเอียด",
    "T2" => "ลูกค้า",
    "T3" => "ธนาคาร",
    "T4" => "รออนุมัติ",
    "T5" => "ไม่ผ่าน",
    "T6" => "ผ่าน",
    "btn" => [
        "edit" => "แก้ไข",
        "add" => "เพิ่ม",
        "save" => "บันทึก",
        "show" => "แสดง",
        "delete" => "ลบ",
        "close" => "ปิด",
        "detail" => "รายละเอียด",
        "Roles" => "จัดการเมนู"
    ],
    "text" => [
        "number-row" => "ลำดับ",
        "management" => "จัดการ",
        "detail" => "รายละเอียด",
        "select" => "เลือก",
        "currency" => "บาท",
        "date" => "วันที่",
        "btn" => [],
        "agent" => "เอเย่นต์",
        "linkError" => "ลิงค์นี้อาจถูกใช้งานไปแล้ว หรือ หมดอายุ",
        "linkSuccess" => "เพิ่มรหัสแนะนำสำเร็จ."
    ],
    "page" => [
        "title" => "หน้าหลัก",
        'dashboard' => [
            "title" => 'แดชบอร์ด',
            'text' => [
                "TotalBalance" => "ยอดทั้งหมด(บัญชี)",
                "SummaryBalance" => "สรุปกำไรรายปี",
                "groupNumber" => "จำนวนห้อง",
                "groupRoom" => "ห้อง",
                "bankNumber" => "บัญชีธนาคาร",
                "bank" => "บัญชี",
                "remaining" => "ผลกำไรทั้งหมด",
            ]
        ],
        'bank' => [
            "title" => 'ข้อมูลบัญชี',
            "text" => [
                "money-sum" => "ยอดทั้งหมด",
                "table-name" => "รายชื่อบัญชีธนาคาร",
                "table" => [
                    "thead" => [
                        "bank-name" => "ธนาคาร",
                        "bank-account-name" => "ชื่อบัญชี",
                        "bank-number" => "เลขบัญชี",
                        "money-totle" => "คงเหลือ",
                    ]
                ],
                "label-bank" => "ธนาคาร",
                "label-blit_name" => "ชื่อบัญชี",
                "label-blit_number" => "เลขที่บัญชี",
                "label-blit_image" => "รูปภาพ",

            ],
            "show" => [
                "text" => [
                    "showImage" => "แสดงรูปภาพ",
                    "header-info" => "ข้อมูลบัญชี",
                    "info-p" => "แสดงเนื้อหาจากบัญชี",
                    "table-name" => "รายการเดินบัญชี",
                    "table" => [
                        "thead" => [
                            "detail" => "รายการ",
                            "bstate_IN" => "เงินเข้า",
                            "bstate_out" => "เงินออก",
                            "bstate_note" => "หมายเหตุ",
                            "bstate_remain" => "คงเหลือ",
                            "ad_name" => "ผู้ดูแล",
                        ],
                        "body" => [
                            "bstate_IN" => "ได้รับเงินจาก {name}",
                            "bstate_out" => "{name} ได้ถอนเงิน"
                        ]
                    ],
                    "label-user" => "ลูกค้า",
                    "label-money_incoming" => "เงินเข้า",
                    "label-money_out" => "เงินออก",
                    "label-bstate_slip" => "หลักฐานการโอน(ถ้ามี)",

                    "label-trail" => "เส้นทางการเงิน",
                    "label-radio-type-2" => "จากลูกค้า",
                    "label-radio-type-1" => "อื่น ๆ",
                ],
                "btn" => [
                    "withdraw" => "ถอนเงินออกจากบัญชี",
                    "up-money" => "โอนเงินเข้าบัญชี",
                    "delete" => "ลบบัญชี",
                ],
            ]
        ],
        "g-index" => [
            "title" => "รายการชื่อห้อง",
            "info" => "ข้อมูลทั่วไป",
            "btn" => [],
            "text" => [
                "statusIN" => "เข้าร่วม",
                "statusOut" => "ไม่ได้เข้ารวม",
                "money-sum" => "ยอดรวม",
                "money-pay" => "ยอดจ่าย",
                "money-totle" => "กำไร",
                "text-baht" => "บาท",
                "user" => "{count} คน",
                "userText" => "สมาชิก",
                "modal" => [
                    "label-openCardSum" => "จำนวนเปิด",
                    "title" => "ถ่ายทอดสด",
                ],
                "makeLink" => "สร้างลิงคฺ์",
                "modalEdit" => [
                    "label-openCardSum" => "จำนวนเปิด",
                    "title" => "แก้ไขข้อมูลห้อง",
                    "lang" => "ภาษาแสดง",
                    "gamemasters" => "เกมที่เล่น",
                ]
            ],
            "table" => [
                "title" => "รายการห้อง",
                'date' => 'วันที่',
                "thead" => [
                    "room" => "ชื่อห้อง",
                    "games" => "เกมส์ที่เล่น",
                    "status" => "สถานะ",
                    "user" => "สมาชิก"
                ]
            ],
        ],
        "g" => [
            "title" => "รายการชื่อห้อง",
            "info" => "ข้อมูลทั่วไป",
            "btn" => [],
            "text" => [
                "money-sum" => "ยอดรวม",
                "money-pay" => "ยอดจ่าย",
                "money-totle" => "กำไร",
                "text-baht" => "บาท",
                "user" => "สมาชิก {count} คน",
                "userText" => "สมาชิก",
                "modal" => [
                    "label-openCardSum" => "จำนวนเปิด",
                    "title" => "ถ่ายทอดสด",
                ],
                "modalEdit" => [
                    "label-openCardSum" => "จำนวนเปิด",
                    "title" => "แก้ไขข้อมูลห้อง",
                    "lang" => "ภาษาแสดง",
                    "gamemasters" => "เกมที่เล่น",
                    "GRO_InviteLink" => "ลิงค์เชิญ",
                ]
            ],
            "table" => [
                "title" => "ประวัติการถ่ายทอดสด",
                'date' => 'วันที่',
                "thead" => [
                    "count-open" => "จำนวนที่เปิด",
                    "games" => "เกมส์ที่เล่น",
                    "status" => "สถานะ"
                ]
            ],
        ],
        "live" => [
            "text" => [
                "money-sum" => "ยอดรวม",
                "money-pay" => "ยอดจ่าย",
                "money-totle" => "กำไร",
                "table" => [
                    "title" => "รายการรอบเปิด",
                    "thead" => [
                        "count-open" => "รอบเปิดที่",
                        "count-play" => "ครั้งที่เล่น",
                        "count-money" => "ยอดเดิมพัน",
                        "resule-win" => "ชนะ(ตา)",
                        "resule-los" => "แพ้(ตา)",
                        "noney_pay" => "ยอดจ่าย",
                        "noney_sum" => "คงเหลือ",
                        "status" => "สถานะ",
                    ]
                ]
            ],
        ],
        "opencard" => [
            "title" => "รอบเปิด {count}",
            "text" => [
                "money-sum" => "ยอดรวม",
                "money-pay" => "ยอดจ่าย",
                "money-totle" => "กำไร",
                "table" => [
                    "title" => "การเล่น รอบเปิดที่ {count}",
                    "thead" => [
                        "th-picture" => "รูป",
                        "th-memter" => "ผู้เล่น",
                        "th-grName" => "ลงข้าง",
                        "th-quantity" => "ยอดเดิมพัน",
                        "th-remain" => "คงเหลือ",
                        "th-win-los" => "ผล",
                        "count-money" => "ยอดได้",
                        "noney_pay" => "ยอดคืน",
                        "noney_sum" => "คงเหลือ",
                        "th-result" => "ผลออก",
                    ]
                ],
                "btn" => [
                    "saveCard" => "บันทึกผลชนะ",
                    "open" => "เริ่มเดิมพัน",
                    "stop" => "ปิดเดิมพัน",
                    "toMain" => "กลับหน้าห้อง"
                ],
                "modal" => [
                    "title" => "บันทึก",
                    "label-win" => "ผลชนะ"
                ]
            ]
        ],
        "member" => [
            "title" => "รายชื่อสมาชิก",
            "btn" => [],
            "text" => [
                "userAll" => "จำนวนสมาชิก",
                // "" => "จำนวนสมาชิก",
                "momeySum" => "คงเหลือรวม",
                "person" => "คน",
                "groupText" => "ห้องที่อยู่",
                "table" => [
                    "title" => "รายชื่อสมาชิก",
                    "thead" => [
                        "pictureUrl" => "โปรไฟล์",
                        "userId" => "ไอดีสมาชิก",
                        "displayName" => "ชื่อแสดง",
                        "follow" => "ติดตาม",
                        "date" => "วันที่",
                        "user_remain" => "คงเหลือ",
                        "detail" => "รายละเอียด",
                        "user_room" => "เข้าร่วม",
                        "room" => "ห้อง"
                    ],
                ]
            ],
            "show" => [
                "text" => [
                    "showImage" => "รูปโปรไฟล์",
                    "header-info" => "โปรไฟล์",
                    "displayName" => "ชื่อที่แสดง",
                    "lang" => "ภาษาที่แสดง",
                    "follow" => "การติดตาม",
                    "moneyCount" => "ยอดคงเหลือ",
                    "table" => [
                        "groups" => [
                            "table-name" => "รายชื่อกลุ่มที่อยู่",
                            "thead" => [
                                "room" => "ชื่อห้อง",
                                // "roomID" => "I"
                                "countPlay" => "จำนวนที่เล่น(รอบ)"
                            ]
                        ],
                        "statement" => [
                            "table-name" => "รายการเดินบัญชี",
                            "thead" => [
                                "detail" => "รายการ",
                                "statement_IN" => "เงินเข้า",
                                "statement_OUT" => "เงินออก",
                                "statement_remain" => "คงเหลือ",
                                "statement_note" => "หมายเหตุ",
                                "ad_name" => "ผู้ดูแล"
                            ]
                        ],
                        "body" => [
                            "statement_IN" => "เติมเงินเข้าบัญชี {name}",
                            "statement_out" => "ถอนเงินออกจากบัญชี {name}",
                        ]
                    ],
                    "modal" => [
                        "bank" => "ธนาคารปลายทาง",
                        "label-money_incoming" => "เงินเข้า",
                        "label-money_out" => "จำนวนต้องการถอน",
                        "label-bstate_slip" => "หลักฐานการโอน(ถ้ามี)",

                    ]
                ],
                "btn" => [
                    "delete" => "ลบบัญชี",
                    "edit" => "แก้ไขบัญชี",
                    "withdraw" => "ถอดเงินออกจากบัญชี",
                    "up-money" => "เติมเงินเข้าบัญชี",
                    "addAgent" => "ผูกเอเย่นต์"
                ],
            ]
        ],
        "admin" => [
            "btn" => [
                "showmodal" => "เพิ่มผู้ดูแล"
            ],
            "title" => "จัดการผู้ดูแล",
            "text" => [
                "modal" => [
                    "title" => "เพิ่มผู้ดูแล",
                    "role" => "สถานะสิทธ์",
                    "label-ac_email" => 'อีเมล',
                    "label-ac_password" => 'รหัสผ่าน',
                    "label-confirm_password" => "ยืนยันรหัสผ่าน",
                    "label-ac_fname" => 'ชื่อ',
                    "label-ac_lname" => 'สกุล',
                    "label-ac_niname" => 'ชื่อเล่น',
                ],
                "modalMenu" => [
                    "title" => "กำหนดสิทธ์เมนู",
                    "role" => "สถานะสิทธ์",
                    "label-ac_email" => 'อีเมล',
                    "label-ac_password" => 'รหัสผ่าน',
                    "label-confirm_password" => "ยืนยันรหัสผ่าน",
                    "label-ac_fname" => 'ชื่อ',
                    "label-ac_lname" => 'สกุล',
                    "label-ac_niname" => 'ชื่อเล่น',
                ],
                "userAll" => "พนักงานทั้งหมด",
                "person" => "คน",
                "table" =>  [
                    "title" => "รายชื่อผู้ดูแล",
                    "thead" => [
                        "date" => 'วันที่สร้าง',
                        "ad_code" => "โค้ดประจำตัว",
                        "displayName" => "ชื่อ",
                        "email" => "อีเมล",
                        "roleName" => "สิทธ์",
                        "referral" => "รหัสแนะนำ"
                    ]
                ]
            ]
        ]
    ]
];
