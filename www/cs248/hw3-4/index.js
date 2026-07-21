/* global bootstrap */

// The number of movies in the database (for computing page count)
const MOVIE_COUNT = 565

// Global variables for page information
let curPage = 1
let maxPages = -1

// fetch wrapper
async function fetchn (url, opts) {
  try {
    if (!url) throw new Error('missing url for request')
    console.log(url)
    const response = await fetch(url, opts)
    if (!response.ok) {
      throw new Error(`Response status: ${response.status}`)
    }
    console.log(response.statusText, response.status)
    return response.json()
  } catch (error) {
    console.error(error.message)
  }
}

// Initialize the details modal
const detailsModal = new bootstrap.Modal('#movieModal')

// This event runs when the DOM is ready and the document is loaded
document.addEventListener('DOMContentLoaded', async () => {
  // Compute the initial maxPages value
  maxPages = Math.ceil(MOVIE_COUNT / parseInt(document.getElementById('perPage').value))

  // Add event listeners for the sorting and per-page controls
  document.getElementById('perPage').addEventListener('change', updatePerPage)
  document.getElementById('orderBy').addEventListener('change', reloadMovieData)

  // Load the initial movie data and build the initial paginator
  await reloadMovieData()
  rebuildPaginator()
})

// Callback function for the page buttons
// (just like the lecture video so I've done this one for you)
function updateCurrentPage (newPage) {
  curPage = Math.max(1, Math.min(newPage, maxPages))
  rebuildPaginator()
  reloadMovieData()
}

// Recompute the maxPages value and reload the movie data
// (just like the lecture video so I've done this one for you)
function updatePerPage () {
  maxPages = Math.ceil(MOVIE_COUNT / parseInt(document.getElementById('perPage').value))
  if (curPage > maxPages) {
    curPage = maxPages
  }

  rebuildPaginator()
  reloadMovieData()
}

// Initiate a fetch() call to retrieve data for the current page
// NOTE: You may want to make this an 'async' function and use 'await'
async function reloadMovieData () {
  // Retrieve the orderBy and perPage values from the page
  // Add event listeners for the sorting and per-page controls
  const perPage = document.getElementById('perPage')
  perPage.addEventListener('change', updatePerPage)

  const orderBy = document.getElementById('orderBy')
  orderBy.addEventListener('change', reloadMovieData)

  // Use the Fetch api to retrieve the data from movieListJSON.php
  const url = new URL('http://localhost:3000/cs248/hw3-4/movieListJSON.php')
  url.search = new URLSearchParams({ perPage: perPage.value, orderBy: orderBy.value, page: curPage }).toString()
  const movieData = await fetchn(url, { method: 'GET' })

  // Call rebuild movie grid with the retrieved movie data
  rebuildMovieGrid(movieData)
}

// Clear and rebuild the movie grid (called when movie data is ready)
function rebuildMovieGrid (movieData) {
  // Get a reference to the movieGrid element and clear its content.
  //       To clear content, call element.removeChild(element.lastChild) inside a loop.
  //       Do not just set innerHTML to the empty string.
  const movieGrid = document.getElementById('movieGrid')
  movieGrid.replaceChildren()
  // Loop over the movies and make a "Tile" for each one, then add it to the grid
  //       (you should use the function makeMovieTile() to make the tile)
  for (const movie in movieData) {
    movieGrid.appendChild(makeMovieTile(movieData[movie]))
  }
}

// Construct a 'tile' (a 'card' in bootstrap) with the summary info for one movie
// - This is probably the trickiest function! (use innerHTML to save time)
// - Don't forget to set an event listener for when the tile is clicked to show the details.
function makeMovieTile (movie) {
  // Make a new 'div' element that is the root div from the example in the
  //       assignment instructions. Set it's .className variable appropriately.
  const div = document.createElement('div')
  div.classList.add('col-6', 'col-sm-6', 'col-md-4', 'col-lg-3')

  // Set the .innerHTML attribute to the rest of the example in the instructions.
  //       Use a parameter string (with ``) to span multiple lines and fill in variables.
  div.innerHTML = `
    <div class="card my-2" style="cursor: pointer;">
    <h5 class="card-header text-truncate">
      ${movie?.title}
    </h5>
    <div class="card-body" style="height: 352px;">
      <img class="mx-auto my-0 d-block" alt="${movie?.title} poster thumbnail"
        height="250px" src="../dbExamples/images/myflix/thumbs/${movie?.image}" />
      <div class="card-text text-muted h6 mt-2">
        ${movie?.year}, ${movie?.rated}<br>${movie?.genres}
      </div>
    </div>
  </div>
  `
  // Set the 'click' event for the tile to be a function that calls
  //       requestDetails() passing the proper movie ID.
  div.addEventListener('click', () => {
    requestDetails(movie?.id)
  })

  // Return the completed movie tile
  return div
}

// Initiate a fetch() call to get the details for one movie
async function requestDetails (movieID) {
  // Use the fetch() api to retrieve the data from movieDetailsJSON.php
  const url = new URL('http://localhost:3000/cs248/hw3-4/movieDetailsJSON.php')
  url.search = new URLSearchParams({ id: movieID }).toString()
  const movieData = await fetchn(url, { method: 'GET' })

  // Call detailsReceived() with the returned movie data
  detailsReceived(movieData?.[0])
}

// The callback function for when movie DETAILS are received
function detailsReceived (movie) {
  console.dir(movie)
  // Set all of the relevant fields in the details modal.
  // - Look for everything with an id like #movieSomething
  // - e.g. #movieTitle, #movieDirectors, #moviePlot, etc.
  // - Take care with the image, use .setAttribute() to set 'src' and 'alt'
  // - The path to the image should start with '../dbExamples/images/myflix/posters/'
  const movieTitle = document.getElementById('movieTitle')
  const movieDirectors = document.getElementById('movieDirectors')
  const moviePlot = document.getElementById('moviePlot')
  const moviePoster = document.getElementById('moviePoster')
  const movieIMDB = document.getElementById('movieIMDB')
  const movieRated = document.getElementById('movieRated')
  const movieWriters = document.getElementById('movieWriters')
  const movieActors = document.getElementById('movieActors')
  const movieGenres = document.getElementById('movieGenres')

  movieTitle.innerText = movie?.title
  movieDirectors.innerText = movie?.directors
  movieActors.innerText = movie?.actors
  moviePlot.innerText = movie?.description
  moviePoster.setAttribute('src', `../dbExamples/images/myflix/posters/${movie?.image}`)
  movieIMDB.innerText = movie?.imdbrating
  movieWriters.innerText = movie?.writers
  movieGenres.innerText = movie?.genres
  movieRated.innerText = movie?.rated

  // Shows the modal (call this last)
  detailsModal.show()
}

// Clear and rebuild the paginator buttons
// (this is just like from the lecture so I have done it for you)
function rebuildPaginator () {
  const paginator = document.getElementById('paginator')
  paginator.innerHTML = ''
  paginator.appendChild(makePaginatorButton('previous'))
  for (let i = 1; i <= maxPages; i++) {
    paginator.appendChild(makePaginatorButton(i))
  }
  paginator.appendChild(makePaginatorButton('next'))
}

// Make a paginator button
// (this is just like from the lecture so I have done it for you)
function makePaginatorButton (page) {
  // Create the li element for the button
  const pageButton = document.createElement('li')
  pageButton.classList.add('page-item')

  // Create the inner link tag
  const linkTag = document.createElement('a')
  linkTag.classList.add('page-link')
  linkTag.href = '#'
  pageButton.appendChild(linkTag)

  if (page === 'previous' || page === 'next') {
    // Make icon
    const prevIcon = document.createElement('span')
    prevIcon.setAttribute('aria-hidden', 'true')
    prevIcon.innerHTML = (page === 'previous' ? '&laquo;' : '&raquo;')

    // Update link tag label
    linkTag.setAttribute('aria-label', page)
    linkTag.appendChild(prevIcon)

    // Disable if needed
    if ((page === 'previous' && curPage <= 1) || (page === 'next' && curPage >= maxPages)) {
      pageButton.classList.add('disabled')
    }

    // Add event listener
    if (page === 'previous') {
      pageButton.addEventListener('click', () => {
        updateCurrentPage(curPage - 1)
      })
    } else {
      pageButton.addEventListener('click', () => {
        updateCurrentPage(curPage + 1)
      })
    }
  } else {
    // Update link tag label
    linkTag.innerText = page

    // Add active class if needed
    if (page === curPage) {
      pageButton.classList.add('active')
    }

    // Add event listener
    pageButton.addEventListener('click', () => {
      updateCurrentPage(page)
    })
  }

  // Return the button
  return pageButton
}
