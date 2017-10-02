/* This file is part of CoCal.
 *
 * CoCal is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * CoCal is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see
 *
 *  http://www.gnu.org/licenses/
 *
 *
 * Copyright (C)
 *  2011-2013 Steffen Vogel <post@steffenvogel.de>
 *  2015-2017 Alexander Haase <ahaase@alexhaase.de>
 */

/** \brief Get the date with \p offset days from now.
 *
 *
 * \param offset Number of days as offset from the current date.
 *
 * \return The calculated date with \p offset.
 */
function cocal_date_offset(offset)
{
  var now = new Date();
  now.setDate(now.getDate() + offset);
  return now;
}


/** \brief Show the CAMPUS Office calendar feed URL.
 *
 * \details This function adds the CAMPUS Office calendar feed URL in the link
 *  to be displayed for the user and displays the (currently hidden) output
 *  panel.
 *
 *
 * \param url The CAMPUS Office calendar feed URL.
 */
function cocal_set_url(url)
{
  $('#url').attr("href", url);
  $('#url').text(url);
  $('#output').attr("class", "show");
}


/** \brief Generate the CAMPUS Office calendar feed URL.
 *
 * \details This function generates the CAMPUS Office calendar feed URL with the
 *  user's input and shows the generated URL in the output panel.
 */
function cocal_generate_url()
{
  /* Generate the URL for the CAMPUS Office calendar feed with the user's input
   * of the URL generator form. */
  var url = 'https://' + $('#cocal_server').val()
          + '/views/calendar/iCalExport.asp'
          + '?u=' + encodeURIComponent($('#username').val())
          + '&p=' + encodeURIComponent($('#password').val())
          + '&startdt=' + cocal_date_offset(-30).toLocaleDateString('de')
          + '&enddt=' + cocal_date_offset(3650).toLocaleDateString('de');

  /* Show the URL in the output panel. */
  cocal_set_url(url);
}
