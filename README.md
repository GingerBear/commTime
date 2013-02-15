commTime
========

A Sample Common Time Picker

Database Schema
========
event {
	eid		int(11)
	ename 	varchar(200)
	enote 	varchar(200)
	ecode	int(11)
}

people {
	pid		int(11)
	pname	varchar(50)
}

time {
	tid		int(11)
	pid		int(11)
	eid		int(11)
	etime_from	datetime
	etime_to	datetime
}