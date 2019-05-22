/*==============================================================*/
/* Database name:  iproject2                                    */
/* Script:		   FUNCTIONS	                                */
/* Created on:     21-05-2019		                            */
/*==============================================================*/

/*==============================================================*/
/* Functie  voor het strippen van HTML code                     */
/* Functie  voor het strippen van HTML code                     */
/*==============================================================*/
CREATE FUNCTION StripHTML (@HTMLText VARCHAR(MAX))
RETURNS VARCHAR(MAX) AS
BEGIN
    DECLARE @Start INT
    DECLARE @End INT
    DECLARE @Length INT
    SET @Start = CHARINDEX('<',@HTMLText)
    SET @End = CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText))
    SET @Length = (@End - @Start) + 1
    WHILE @Start > 0 AND @End > 0 AND @Length > 0
    BEGIN
        SET @HTMLText = STUFF(@HTMLText,@Start,@Length,'')
        SET @Start = CHARINDEX('<',@HTMLText)
        SET @End = CHARINDEX('>',@HTMLText,CHARINDEX('<',@HTMLText))
        SET @Length = (@End - @Start) + 1
    END
    RETURN LTRIM(RTRIM(@HTMLText))
END
GO

ALTER FUNCTION StripHTML
(
@HTMLText varchar(MAX)
)
RETURNS varchar(MAX)
AS
BEGIN
DECLARE @Start  int
DECLARE @End    int
DECLARE @Length int

-- Replace the HTML entity &amp; with the '&' character (this needs to be done first, as
-- '&' might be double encoded as '&amp;amp;')
SET @Start = CHARINDEX('&amp;', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '&')
SET @Start = CHARINDEX('&amp;', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1
END

-- Replace the HTML entity &lt; with the '<' character
SET @Start = CHARINDEX('&lt;', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '<')
SET @Start = CHARINDEX('&lt;', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1
END

-- Replace the HTML entity &gt; with the '>' character
SET @Start = CHARINDEX('&gt;', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '>')
SET @Start = CHARINDEX('&gt;', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1
END

-- Replace the HTML entity &amp; with the '&' character
SET @Start = CHARINDEX('&amp;amp;', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '&')
SET @Start = CHARINDEX('&amp;amp;', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1
END

-- Replace the HTML entity &nbsp; with the ' ' character
SET @Start = CHARINDEX('&nbsp;', @HTMLText)
SET @End = @Start + 5
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, ' ')
SET @Start = CHARINDEX('&nbsp;', @HTMLText)
SET @End = @Start + 5
SET @Length = (@End - @Start) + 1
END

-- Replace any <br> tags with a newline
SET @Start = CHARINDEX('<br>', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, CHAR(13) + CHAR(10))
SET @Start = CHARINDEX('<br>', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1
END

-- Replace any <br/> tags with a newline
SET @Start = CHARINDEX('<br/>', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, 'CHAR(13) + CHAR(10)')
SET @Start = CHARINDEX('<br/>', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1
END

-- Replace any <br /> tags with a newline
SET @Start = CHARINDEX('<br />', @HTMLText)
SET @End = @Start + 5
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, 'CHAR(13) + CHAR(10)')
SET @Start = CHARINDEX('<br />', @HTMLText)
SET @End = @Start + 5
SET @Length = (@End - @Start) + 1
END

-- Remove anything between <whatever> tags
SET @Start = CHARINDEX('<', @HTMLText)
SET @End = CHARINDEX('>', @HTMLText, CHARINDEX('<', @HTMLText))
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '')
SET @Start = CHARINDEX('<', @HTMLText)
SET @End = CHARINDEX('>', @HTMLText, CHARINDEX('<', @HTMLText))
SET @Length = (@End - @Start) + 1
END

RETURN LTRIM(RTRIM(@HTMLText))

END
