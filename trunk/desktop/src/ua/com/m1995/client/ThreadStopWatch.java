package ua.com.m1995.client;

import java.awt.FlowLayout;

import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.SwingUtilities;

public class ThreadStopWatch {

	JLabel jlab;

	Thread thrd;

	ProgressData now = null;

	int previous = 0;

	public ThreadStopWatch(ProgressData progressData) {

		now = progressData;

		final JFrame jfrm = new JFrame();

		jfrm.getContentPane().setLayout(new FlowLayout());
		
		jfrm.setSize(200, 50);
		jfrm.setLocation(300, 200);
		jfrm.setAlwaysOnTop(true);

		jfrm.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

		jlab = new JLabel();

		Runnable myThread = new Runnable() {
			public void run() {

				

					while (now.active) {

						try {
						Thread.sleep(500);

						if (now.now != previous) {

							previous = now.now;

							SwingUtilities.invokeLater(new Runnable() {
								public void run() {
									jlab
											.setText("" + now.now + " / "
													+ now.max);
								}
							});

						}
					

						} catch (InterruptedException e) {
						}
				
					}

				jfrm.dispose();

			}
		};

		thrd = new Thread(myThread);
		thrd.start();
		jfrm.getContentPane().add(jlab);
		jfrm.setVisible(true);
	}

	public static void use(ProgressData progressData) {

		final ProgressData pData = progressData;

		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				new ThreadStopWatch(pData);
			}
		});

	}
	/*
	 * public static void main(String args[]) {
	 * 
	 * final ProgressData pData = new ProgressData(); use(pData);
	 * 
	 * for (int i = 0; i < 100; i++) { try { Thread.sleep(100); } catch
	 * (Exception e) { } ; pData.now = i; } pData.active = false;
	 *  }
	 */

}
