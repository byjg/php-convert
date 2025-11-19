# Generator Scripts

This directory contains PHP scripts used to generate character conversion tables and test data for the php-convert library. These scripts help maintain and update the character mappings used in the library's conversion functions.

## Files

### _base.php
The base file containing a comprehensive mapping of characters with their:
- UTF-8 representation
- HTML entity name (e.g., `&aacute;`)
- HTML decimal code (e.g., `&#192;`)
- Description (e.g., "Capital a with grave accent")

This file serves as the source data for other generator scripts.

### toentity.php
Generates the character-to-HTML-entity conversion arrays used in the `FromUTF8::toHtmlEntities()` method. It processes the base data and creates a multi-level array structure that maps UTF-8 character codes to their corresponding HTML entities.

### fromentity.php
Generates the HTML-entity-to-character conversion arrays used in the `ToUTF8::fromHtmlEntities()` method. It creates mappings from both named entities (e.g., `&aacute;`) and decimal codes (e.g., `&#192;`) to their corresponding UTF-8 character codes.

### totest.php
Generates test data strings used in the unit tests. It creates pairs of strings:
1. A string containing UTF-8 characters
2. The corresponding string with HTML entities

This helps maintain comprehensive test cases for the conversion functions.

## Usage

These scripts are development tools used to:
- Update character mappings when new entities are added
- Generate test data for new character conversions
- Maintain consistency between different conversion methods

To update the conversion tables:
1. Modify `_base.php` with new character mappings if needed
2. Run the appropriate generator script
3. Copy the generated output to the corresponding location in the library code 