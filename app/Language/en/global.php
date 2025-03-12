<?php
return [
    "T1" => "Details",
    "T2" => "Customer",
    "T3" => "Bank",
    "T4" => "Pending Approval",
    "T5" => "Rejected",
    "T6" => "Approved",
    "btn" => [
        "edit" => "Edit",
        "add" => "Add",
        "save" => "Save",
        "show" => "Show",
        "delete" => "Delete",
        "close" => "Close",
        "detail" => "Detail",
        "Roles" => "Manage Menu"
    ],
    "text" => [
        "number-row" => "No.",
        "management" => "Management",
        "detail" => "Details",
        "select" => "Select",
        "currency" => "Baht",
        "date" => "Date",
        "btn" => [],
        "agent" => "Agent",
        "linkError" => "This link might have been used or expired.",
        "linkSuccess" => "Successfully added referral code."
    ],
    "page" => [
        "title" => "Home",
        'dashboard' => [
            "title" => 'Dashboard',
            'text' => [
                "TotalBalance" => "Total Balance (Accounts)",
                "SummaryBalance" => "Annual Profit Summary",
                "groupNumber" => "Number of Rooms",
                "groupRoom" => "Rooms",
                "bankNumber" => "Bank Accounts",
                "bank" => "Accounts",
                "remaining" => "Total Profit",
            ]
        ],
        'bank' => [
            "title" => 'Account Information',
            "text" => [
                "money-sum" => "Total Amount",
                "table-name" => "Bank Account List",
                "table" => [
                    "thead" => [
                        "bank-name" => "Bank",
                        "bank-account-name" => "Account Name",
                        "bank-number" => "Account Number",
                        "money-totle" => "Remaining",
                    ]
                ],
                "label-bank" => "Bank",
                "label-blit_name" => "Account Name",
                "label-blit_number" => "Account Number",
                "label-blit_image" => "Image",
            ],
            "show" => [
                "text" => [
                    "showImage" => "Show Image",
                    "header-info" => "Account Information",
                    "info-p" => "Display account content",
                    "table-name" => "Account Transactions",
                    "table" => [
                        "thead" => [
                            "detail" => "Description",
                            "bstate_IN" => "Incoming Funds",
                            "bstate_out" => "Outgoing Funds",
                            "bstate_note" => "Notes",
                            "bstate_remain" => "Remaining",
                            "ad_name" => "Admin",
                        ],
                        "body" => [
                            "bstate_IN" => "Received money from {name}",
                            "bstate_out" => "{name} withdrew money"
                        ]
                    ],
                    "label-user" => "Customer",
                    "label-money_incoming" => "Incoming Funds",
                    "label-money_out" => "Outgoing Funds",
                    "label-bstate_slip" => "Transfer Evidence (if any)",
                    "label-trail" => "Financial Route",
                    "label-radio-type-2" => "From Customer",
                    "label-radio-type-1" => "Other",
                ],
                "btn" => [
                    "withdraw" => "Withdraw from Account",
                    "up-money" => "Deposit to Account",
                    "delete" => "Delete Account",
                ],
            ]
        ],
        "g-index" => [
            "title" => "Room List",
            "info" => "General Information",
            "btn" => [],
            "text" => [
                "statusIN" => "Joined",
                "statusOut" => "Not Joined",
                "money-sum" => "Total Amount",
                "money-pay" => "Payment Amount",
                "money-totle" => "Profit",
                "text-baht" => "Baht",
                "user" => "{count} members",
                "userText" => "Members",
                "modal" => [
                    "label-openCardSum" => "Number of Opens",
                    "title" => "Live Broadcast",
                ],
                "makeLink" => "Create Link",
                "modalEdit" => [
                    "label-openCardSum" => "Number of Opens",
                    "title" => "Edit Room Details",
                    "lang" => "Display Language",
                    "gamemasters" => "Game Played",
                ]
            ],
            "table" => [
                "title" => "Room List",
                'date' => 'Date',
                "thead" => [
                    "room" => "Room Name",
                    "games" => "Games Played",
                    "status" => "Status",
                    "user" => "Members"
                ]
            ],
        ],
        "g" => [
            "title" => "Room List",
            "info" => "General Information",
            "btn" => [],
            "text" => [
                "money-sum" => "Total Amount",
                "money-pay" => "Payment Amount",
                "money-totle" => "Profit",
                "text-baht" => "Baht",
                "user" => "{count} members",
                "userText" => "Members",
                "modal" => [
                    "label-openCardSum" => "Number of Opens",
                    "title" => "Live Broadcast",
                ],
                "modalEdit" => [
                    "label-openCardSum" => "Number of Opens",
                    "title" => "Edit Room Details",
                    "lang" => "Display Language",
                    "gamemasters" => "Game Played",
                    "GRO_InviteLink" => "Invite Link",
                ]
            ],
            "table" => [
                "title" => "Live Broadcast History",
                'date' => 'Date',
                "thead" => [
                    "count-open" => "Open Count",
                    "games" => "Games Played",
                    "status" => "Status"
                ]
            ],
        ],
        "live" => [
            "text" => [
                "money-sum" => "Total Amount",
                "money-pay" => "Payment Amount",
                "money-totle" => "Profit",
                "table" => [
                    "title" => "Round List",
                    "thead" => [
                        "count-open" => "Round Number",
                        "count-play" => "Play Count",
                        "count-money" => "Bet Amount",
                        "resule-win" => "Win (rounds)",
                        "resule-los" => "Lose (rounds)",
                        "noney_pay" => "Payment Amount",
                        "noney_sum" => "Remaining",
                        "status" => "Status",
                    ]
                ]
            ],
        ],
        "opencard" => [
            "title" => "Round Open {count}",
            "text" => [
                "money-sum" => "Total Amount",
                "money-pay" => "Payment Amount",
                "money-totle" => "Profit",
                "table" => [
                    "title" => "Round Open {count} Plays",
                    "thead" => [
                        "th-picture" => "Image",
                        "th-memter" => "Player",
                        "th-grName" => "Side Bet",
                        "th-quantity" => "Bet Amount",
                        "th-remain" => "Remaining",
                        "th-win-los" => "Result",
                        "count-money" => "Earnings",
                        "noney_pay" => "Refund",
                        "noney_sum" => "Remaining",
                        "th-result" => "Outcome",
                    ]
                ],
                "btn" => [
                    "saveCard" => "Save Win Result",
                    "open" => "Start Betting",
                    "stop" => "Stop Betting",
                    "toMain" => "Back to Room"
                ],
                "modal" => [
                    "title" => "Save",
                    "label-win" => "Winning Result"
                ]
            ]
        ],
        "member" => [
            "title" => "Member List",
            "btn" => [],
            "text" => [
                "userAll" => "Total Members",
                "momeySum" => "Total Remaining",
                "person" => "People",
                "groupText" => "Room Joined",
                "table" => [
                    "title" => "Member List",
                    "thead" => [
                        "pictureUrl" => "Profile",
                        "userId" => "Member ID",
                        "displayName" => "Display Name",
                        "follow" => "Follow",
                        "date" => "Date",
                        "user_remain" => "Remaining",
                        "detail" => "Details",
                        "user_room" => "Joined",
                        "room" => "Room"
                    ],
                ]
            ],
            "show" => [
                "text" => [
                    "showImage" => "Profile Picture",
                    "header-info" => "Profile",
                    "displayName" => "Display Name",
                    "lang" => "Display Language",
                    "follow" => "Following",
                    "moneyCount" => "Remaining Balance",
                    "table" => [
                        "groups" => [
                            "table-name" => "Groups Joined",
                            "thead" => [
                                "room" => "Room Name",
                                "countPlay" => "Play Count (Rounds)"
                            ]
                        ],
                        "statement" => [
                            "table-name" => "Transaction List",
                            "thead" => [
                                "detail" => "Description",
                                "statement_IN" => "Incoming",
                                "statement_OUT" => "Outgoing",
                                "statement_remain" => "Remaining",
                                "statement_note" => "Notes",
                                "ad_name" => "Admin"
                            ]
                        ],
                        "body" => [
                            "statement_IN" => "Added funds to account {name}",
                            "statement_out" => "Withdrawn funds from account {name}",
                        ]
                    ],
                    "modal" => [
                        "bank" => "Destination Bank",
                        "label-money_incoming" => "Incoming Funds",
                        "label-money_out" => "Withdrawal Amount",
                        "label-bstate_slip" => "Transfer Evidence (if any)",
                    ]
                ],
                "btn" => [
                    "delete" => "Delete Account",
                    "edit" => "Edit Account",
                    "withdraw" => "Withdraw from Account",
                    "up-money" => "Add Funds to Account",
                    "addAgent" => "Link Agent"
                ],
            ]
        ],
        "admin" => [
            "btn" => [
                "showmodal" => "Add Admin"
            ],
            "title" => "Admin Management",
            "text" => [
                "modal" => [
                    "title" => "Add Admin",
                    "role" => "Role Permission",
                    "label-ac_email" => 'Email',
                    "label-ac_password" => 'Password',
                    "label-confirm_password" => "Confirm Password",
                    "label-ac_fname" => 'First Name',
                    "label-ac_lname" => 'Last Name',
                    "label-ac_niname" => 'Nickname',
                ],
                "modalMenu" => [
                    "title" => "Set Menu Permissions",
                    "role" => "Role Permission",
                    "label-ac_email" => 'Email',
                    "label-ac_password" => 'Password',
                    "label-confirm_password" => "Confirm Password",
                    "label-ac_fname" => 'First Name',
                    "label-ac_lname" => 'Last Name',
                    "label-ac_niname" => 'Nickname',
                ],
                "userAll" => "Total Staff",
                "person" => "People",
                "table" => [
                    "title" => "Admin List",
                    "thead" => [
                        "date" => 'Created Date',
                        "ad_code" => "Admin Code",
                        "displayName" => "Name",
                        "email" => "Email",
                        "roleName" => "Role",
                        "referral" => "Referral Code"
                    ]
                ]
            ]
        ]
    ]
];

// return [
//     "btn" => [
//         "edit" => "Edit",
//         "add" => "Add",
//         "save" => "Save",
//         "show" => "Show",
//         "delete" => "Delete",
//         "close" => "Close",
//         "detail" => "Details",
//         "Roles" => "Manage Menu"
//     ],
//     "text" => [
//         "number-row" => "No.",
//         "management" => "Management",
//         "detail" => "Details",
//         "select" => "Select",
//         "currency" => "Baht",
//         "date" => "Date",
//         "btn" => [],
//     ],
//     "page" => [
//         "title" => "Home",
//         'dashboard' => [ 
//             "title" => 'Dashboard',
//             'text' => [
//                 "TotalBalance" => "Total Balance (Account)",
//                 "SummaryBalance" => "Annual Profit Summary",
//                 "groupNumber" => "Number of Rooms",
//                 "groupRoom" => "Room",
//                 "bankNumber" => "Bank Accounts",
//                 "bank" => "Account",
//                 "remaining" => "Total Profit",
//             ]
//         ],
//         'bank' => [
//             "title" => 'Account Information',
//             "text" => [
//                 "money-sum" => "Total Amount",
//                 "table-name" => "Bank Account List",
//                 "table" => [
//                     "thead" => [
//                         "bank-name" => "Bank",
//                         "bank-account-name" => "Account Name",
//                         "bank-number" => "Account Number",
//                         "money-totle" => "Balance",
//                     ]
//                 ],
//                 "label-bank" => "Bank",
//                 "label-blit_name" => "Account Name",
//                 "label-blit_number" => "Account Number",
//                 "label-blit_image" => "Image",

//             ],
//             "show" => [
//                 "text" => [
//                     "showImage" => "Show Image",
//                     "header-info" => "Account Information",
//                     "info-p" => "Show account details",
//                     "table-name" => "Account Transaction History",
//                     "table" => [
//                         "thead" => [
//                             "detail" => "Transaction",
//                             "bstate_IN" => "Deposit",
//                             "bstate_out" => "Withdrawal",
//                             "bstate_note" => "Note",
//                             "bstate_remain" => "Remaining",
//                             "ad_name" => "Admin",
//                         ],
//                         "body" => [
//                             "bstate_IN" => "Received money from {name}",
//                             "bstate_out" => "{name} withdrew money"
//                         ]
//                     ],
//                     "label-user" => "Customer",
//                     "label-money_incoming" => "Incoming Money",
//                     "label-money_out" => "Outgoing Money",
//                     "label-bstate_slip" => "Transfer Slip (if any)",

//                     "label-trail" => "Money Trail",
//                     "label-radio-type-2" => "From Customer",
//                     "label-radio-type-1" => "Others",

//                 ],
//                 "btn" => [
//                     "withdraw" => "Withdraw from Account",
//                     "up-money" => "Transfer to Account",
//                     "delete" => "Delete Account",
//                 ],

//             ]
//         ],
//         "g" => [
//             "title" => "Room List",
//             "info" => "General Information",
//             "btn" => [],
//             "text" => [
//                 "money-sum" => "Total Amount",
//                 "money-pay" => "Total Payment",
//                 "money-totle" => "Profit",
//                 "text-baht" => "Baht",
//                 "user" => "{count} Members",
//                 "userText" => "Members",
//                 "modal" => [
//                     "label-openCardSum" => "Open Count",
//                     "title" => "Live Broadcast",
//                 ],
//                 "modalEdit" => [
//                     "label-openCardSum" => "Open Count",
//                     "title" => "Edit Room Information",
//                     "lang" => "Display Language",
//                     "gamemasters" => "Game Played",
//                 ]
//             ],
//             "table" => [
//                 "title" => "Live Broadcast History",
//                 'date' => 'Date',
//                 "thead" => [
//                     "count-open" => "Open Count",
//                     "games" => "Games Played",
//                     "status" => "Status"
//                 ]
//             ],
//         ],
//         "live" => [
//             "text" => [
//                 "money-sum" => "Total Amount",
//                 "money-pay" => "Total Payment",
//                 "money-totle" => "Profit",
//                 "table" => [
//                     "title" => "Open Round List",
//                     "thead" => [

//                         "count-open" => "Open Round",
//                         "count-play" => "Play Count",
//                         "count-money" => "Bet Amount",
//                         "resule-win" => "Wins (Rounds)",
//                         "resule-los" => "Losses (Rounds)",
//                         "noney_pay" => "Total Payment",
//                         "noney_sum" => "Remaining",
//                         "status" => "Status",

//                     ]
//                 ]
//             ],

//         ],
//         "opencard" => [
//             "title" => "Open Round {count}",
//             "text" => [
//                 "money-sum" => "Total Amount",
//                 "money-pay" => "Total Payment",
//                 "money-totle" => "Profit",
//                 "table" => [
//                     "title" => "Play Round {count}",
//                     "thead" => [
//                         "th-picture" => "Image",
//                         "th-memter" => "Player",
//                         "th-grName" => "Side Bet",
//                         "th-quantity" => "Bet Amount",
//                         "th-remain" => "Remaining",
//                         "th-win-los" => "Result",
//                         "count-money" => "Earnings",
//                         "noney_pay" => "Returned Amount",
//                         "noney_sum" => "Remaining",
//                         "th-result" => "Result",
//                     ]
//                 ],
//                 "btn" => [
//                     "saveCard" => "Save Win",
//                     "open" => "Start Betting",
//                     "stop" => "Stop Betting",
//                     "toMain" => "Go back Room",
//                 ],
//                 "modal" => [
//                     "title" => "Save",
//                     "label-win" => "Win Result"
//                 ]
//             ]
//         ],
//         "member" => [
//             "title" => "Member List",
//             "btn" => [],
//             "text" => [
//                 "userAll" => "Total Members",
//                 "momeySum" => "Total Balance",
//                 "person" => "People",
//                 "groupText" => "Room",
//                 "table" => [
//                     "title" => "Member List",
//                     "thead" => [
//                         "pictureUrl" => "Profile",
//                         "userId" => "Member ID",
//                         "displayName" => "Display Name",
//                         "follow" => "Follow",
//                         "date" => "Date",
//                         "user_remain" => "Remaining",
//                         "detail" => "Details",
//                         "user_room" => "Joined",
//                         "room" => "Room"
//                     ],
//                 ]
//             ],
//             "show" => [
//                 "text" => [
//                     "showImage" => "Profile Picture",
//                     "header-info" => "Profile",
//                     "displayName" => "Display Name",
//                     "lang" => "Display Language",
//                     "follow" => "Follow",
//                     "moneyCount" => "Remaining Balance",
//                     "table" => [
//                         "groups" => [
//                             "table-name" => "Group List",
//                             "thead" => [
//                                 "room" => "Room Name",
//                                 "countPlay" => "Play Count (Rounds)"
//                             ]
//                         ],
//                         "statement" => [
//                             "table-name" => "Account Statement",
//                             "thead" => [
//                                 "detail" => "Transaction",
//                                 "statement_IN" => "Deposit",
//                                 "statement_OUT" => "Withdrawal",
//                                 "statement_remain" => "Remaining",
//                                 "statement_note" => "Note",
//                                 "ad_name" => "Admin"
//                             ]
//                         ],
//                         "body" => [
//                             "statement_IN" => "Deposited by {name}",
//                             "statement_out" => "Withdrawn by {name}",
//                         ]
//                     ],
//                     "modal" => [
//                         "bank" => "Destination Bank",
//                         "label-money_incoming" => "Deposit",
//                         "label-money_out" => "Withdrawal Amount",
//                         "label-bstate_slip" => "Transfer Slip (if any)",

//                     ]
//                 ],
//                 "btn" => [
//                     "delete" => "Delete Account",
//                     "withdraw" => "Withdraw from Account",
//                     "up-money" => "Deposit to Account",
//                 ],

//             ]

//         ],
//         "admin" => [
//             "btn" => [
//                 "showmodal" => "Add Admin"
//             ],

//             "title" => "Manage Admins",
//             "text" => [
//                 "modal" => [
//                     "title" => "Add Admin",
//                     "role" => "Role",
//                     "label-ac_email" => 'Email',
//                     "label-ac_password" => 'Password',
//                     "label-confirm_password" => "Confirm Password",
//                     "label-ac_fname" => 'First Name',
//                     "label-ac_lname" => 'Last Name',
//                     "label-ac_niname" => 'Nickname',
//                 ],
//                 "modalMenu" => [
//                     "title" => "Set Menu Permissions",
//                     "role" => "Role",
//                     "label-ac_email" => 'Email',
//                     "label-ac_password" => 'Password',
//                     "label-confirm_password" => "Confirm Password",
//                     "label-ac_fname" => 'First Name',
//                     "label-ac_lname" => 'Last Name',
//                     "label-ac_niname" => 'Nickname',
//                 ],
//                 "userAll" => "Total Employees",
//                 "person" => "People",
//                 "table" =>  [
//                     "title" => "Admin List",
//                     "thead" => [
//                         "date" => 'Creation Date',
//                         "ad_code" => "Admin Code",
//                         "displayName" => "Name",
//                         "email" => "Email",
//                         "roleName" => "Role"
//                     ]
//                 ]
//             ]
//         ]
//     ]
// ];
