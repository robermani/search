import React from 'react';

const SearchResults = ({ results, displayMode, onDisplayModeChange }) => {
  return (
    <div>
      <h2>Search Results</h2>
      <p>{results.length} results found</p>

      {results.length > 0 && (
        <div>
          <label className="mr-3">Display options:</label>
          <div className="form-check form-check-inline">
            <input
              className="form-check-input"
              type="radio"
              name="displayMode"
              id="list"
              value="list"
              checked={displayMode === 'list'}
              onChange={onDisplayModeChange}
            />
            <label className="form-check-label" htmlFor="list">
              List
            </label>
          </div>
          <div className="form-check form-check-inline">
            <input
              className="form-check-input"
              type="radio"
              name="displayMode"
              id="cards"
              value="cards"
              checked={displayMode === 'cards'}
              onChange={onDisplayModeChange}
            />
            <label className="form-check-label" htmlFor="cards">
              Cards
            </label>
          </div>
        </div>
      )}

      {results.length > 0 && displayMode === 'list' ? (
        <ul className="list-group">
          {results.map((result, index) => (
            <li key={index} className="list-group-item">
              <a href={result.link} target="_blank" rel="noopener noreferrer">
                {result.title}
              </a>
            </li>
          ))}
        </ul>
      ) : (
        <div className="card-columns">
          {results.map((result, index) => (
            <div key={index} className="card">
              <div className="card-body">
                <a href={result.link} target="_blank" rel="noopener noreferrer">
                  <p className="card-text">{result.title}</p>
                </a>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default SearchResults;
