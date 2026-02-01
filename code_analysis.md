### Issues Found
- SQL Injection via string concatenation
- No input validation
- No error handling
- Multiple DB connections without safety
- Procedural legacy structure

### Fixes Implemented
- PDO with prepared statements
- Strict input validation
- Centralized DB configuration
- Exception handling
- Clean, readable structure

### Result
The refactored version maintains backward compatibility while
significantly improving security, performance, and maintainability.
