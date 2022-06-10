# date-value-objects

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/apie-lib/date-value-objects/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/apie-lib/date-value-objects/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/apie-lib/date-value-objects/badges/build.png?b=main)](https://scrutinizer-ci.com/g/apie-lib/date-value-objects/build-status/main)

This package is part of the [Apie](https://github.com/apie-lib) library.
The code is maintained in a monorepo, so PR's need to be sent to the [monorepo](https://github.com/apie-lib/apie-lib-monorepo/pulls)

## Documentation
This package contains many Date-related value objects. Why do you want to use these value objects
over DateTimeImmutable in PHP? The thing is that DateTime always contains days, months, years, minutes, seconds, hours, a timezone and microseconds. But in most cases we only use some.

By using these value objects over the PHP datetime objects we can tell if the date format we expect is actually using all these properties.

### Available classes

***DateWithTimezone:*** contains years, months, days, hours, seconds and also timezones. They should be in the format as DateTime::ATOM as a standard.

***HourAndMinutes:*** contains a timestamp with only hours and minutes. It's still possible to call nextMinute 60 time or nextSecond 3600 time to advance an hour here.

***LocalDate:*** contains a date with the format in a local date format, for example '2002-12-31' for 31 december 2002.

**Time:*** contains a timestamp with only hours, minutes and seconds.

**UnixTimestamp:** contains a Unix timestamp.

### Interfaces
***WorksWithDays:***
contains a list of methods to work with days.

***WorksWithMonths:***
contains a list of methods to work with months. Internally it stores a un-normalized day value in
case someone uses nextMonth() or previousMonth() too many times in a row.

***WorksWithTimeIntervals:***
contains a list of methods to work with time periods. 

***WorksWithYears:***
contains a list of methods to work with year counting.
